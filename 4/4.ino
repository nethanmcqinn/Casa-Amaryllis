/*
 * ESP32 Automatic Irrigation System with Moisture Sensor and Plant Detection
 */

#include "Arduino.h"
#include "DFRobotDFPlayerMini.h"

// Moisture sensor and relay pins
#define RELAY_PIN 27
#define MOISTURE_PIN 36

// Calibration values for moisture sensor
const int raw_min = 2583;
const int raw_max = 1050;
const int THRESHOLD = 50;

// Pump control variables
unsigned long pumpStartTime = 0;
const unsigned long MAX_PUMP_TIME = 30000;

// Color sensor pins
#define S2  0
#define S3  4
#define OUT 2

// DFPlayer pins
#define RX_PIN 22
#define TX_PIN 23

// Use Hardware Serial2 for DFPlayer
HardwareSerial dfPlayerSerial(2);
DFRobotDFPlayerMini myDFPlayer;

struct ColorRange {
    float min;
    float max;
};

struct PlantColorProfile {
    ColorRange red;
    ColorRange green;
    ColorRange blue;
};

PlantColorProfile plantColorProfile = {
    {45, 90}, {50, 90}, {60, 100}
};

bool lastPlantStatus = false;
bool dfPlayerInitialized = false;
unsigned long lastTestTime = 0;

void setup() {
    Serial.begin(9600);
    pinMode(RELAY_PIN, OUTPUT);
    digitalWrite(RELAY_PIN, LOW);
    pinMode(S2, OUTPUT);
    pinMode(S3, OUTPUT);
    pinMode(OUT, INPUT);
    dfPlayerSerial.begin(9600, SERIAL_8N1, RX_PIN, TX_PIN);
    delay(1000);

    if (!myDFPlayer.begin(dfPlayerSerial)) {
        Serial.println(F("DFPlayer initialization failed."));
    } else {
        dfPlayerInitialized = true;
        myDFPlayer.volume(25);
        myDFPlayer.outputDevice(DFPLAYER_DEVICE_SD);
    }

    Serial.println("System initialized.");
}

void loop() {
    // Moisture sensor logic
    int sensor_analog = analogRead(MOISTURE_PIN);
    int moisture = map(sensor_analog, raw_min, raw_max, 0, 100);
    moisture = constrain(moisture, 0, 100);
    Serial.print("Moisture: " + String(moisture) + "%");

    if (moisture > THRESHOLD) {
        if (digitalRead(RELAY_PIN) == HIGH) {
            Serial.println(" - Turning pump OFF");
            digitalWrite(RELAY_PIN, LOW);
        }
    } else {
        if (digitalRead(RELAY_PIN) == LOW) {
            Serial.println(" - Turning pump ON");
            digitalWrite(RELAY_PIN, HIGH);
        }
    }

    // Plant detection logic
    long redReading = readColor(LOW, LOW);
    long greenReading = readColor(HIGH, HIGH);
    long blueReading = readColor(LOW, HIGH);
    bool isPlantDetected = detectPlant(redReading, greenReading, blueReading);

    if (isPlantDetected && !lastPlantStatus) {
        Serial.println(F("Plant detected, playing audio"));
        myDFPlayer.stop();
        delay(100);
        myDFPlayer.play(1);
    } else if (!isPlantDetected && lastPlantStatus) {
        Serial.println(F("No plant detected, stopping audio"));
        myDFPlayer.stop();
    }
    lastPlantStatus = isPlantDetected;
    delay(1000);
}

long readColor(int s2State, int s3State) {
    digitalWrite(S2, s2State);
    digitalWrite(S3, s3State);
    long totalPulse = 0;
    for (int i = 0; i < 10; i++) {
        long pulse = pulseIn(OUT, LOW, 50000);
        if (pulse > 0) {
            totalPulse += pulse;
        }
        delay(10);
    }
    return totalPulse / 10;
}

bool isInRange(float value, ColorRange range) {
    return (value >= range.min && value <= range.max);
}

bool detectPlant(long redReading, long greenReading, long blueReading) {
    bool result = isInRange(redReading, plantColorProfile.red) ||
                  isInRange(greenReading, plantColorProfile.green) ||
                  isInRange(blueReading, plantColorProfile.blue);
    Serial.println(result ? "PLANT DETECTED" : "NO PLANT");
    return result;
}
