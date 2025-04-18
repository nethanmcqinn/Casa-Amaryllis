@extends('layouts.main')

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <div class="profile-intro">
            <div class="profile-picture-container">
                <img src="{{ auth()->user()->profile_picture ? Storage::url(auth()->user()->profile_picture) : asset('images/default-avatar.png') }}" 
                     alt="Profile Picture" 
                     class="profile-picture"
                     id="currentProfilePicture">
                <div class="profile-picture-overlay">
                    <button type="button" id="changePictureBtn" class="change-picture-btn">
                        <i class="fas fa-camera"></i> Change Picture
                    </button>
                </div>
            </div>
            <div class="profile-titles">
                <h1>{{ auth()->user()->name }}</h1>
                <p class="text-muted">{{ auth()->user()->email }}</p>
            </div>
        </div>
    </div>

    <div class="profile-content">
        <div class="profile-card">
            <div class="card-header">
                <h2>Personal Information</h2>
                <button class="btn-edit-info" type="button">Edit Profile</button>
            </div>
            <div class="card-body">
                <div class="info-grid">
                    <div class="info-item">
                        <label>Name</label>
                        <span data-field="name">{{ auth()->user()->name }}</span>
                    </div>
                    <div class="info-item">
                        <label>Email</label>
                        <span data-field="email">{{ auth()->user()->email }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden file input for profile picture -->
<form id="pictureForm" class="hidden">
    @csrf
    <input type="file" id="pictureInput" name="profile_picture" accept="image/*">
</form>

<!-- Edit Profile Modal -->
<div id="editProfileModal" class="modal hidden">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Profile</h2>
            <button type="button" class="modal-close">&times;</button>
        </div>
        <form id="editProfileForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="{{ auth()->user()->name }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel">Cancel</button>
                <button type="submit" class="btn-save">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<style>
/* Add these styles or put them in your CSS file */
.profile-container {
    max-width: 800px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.profile-picture-container {
    position: relative;
    width: 150px;
    height: 150px;
    border-radius: 50%;
    overflow: hidden;
    margin-right: 2rem;
}

.profile-picture {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-picture-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.7);
    padding: 0.5rem;
    opacity: 0;
    transition: opacity 0.3s;
}

.profile-picture-container:hover .profile-picture-overlay {
    opacity: 1;
}

.change-picture-btn {
    width: 100%;
    background: none;
    border: none;
    color: white;
    cursor: pointer;
}

.profile-intro {
    display: flex;
    align-items: center;
    margin-bottom: 2rem;
}

.modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal.hidden {
    display: none;
}

.modal-content {
    background: white;
    border-radius: 8px;
    width: 90%;
    max-width: 500px;
}

.modal-header {
    padding: 1rem;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-body {
    padding: 1rem;
}

.modal-footer {
    padding: 1rem;
    border-top: 1px solid #eee;
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
}

.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
}

.form-group input {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.btn-edit-info {
    padding: 0.5rem 1rem;
    background: #ec4899;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn-save {
    padding: 0.5rem 1rem;
    background: #ec4899;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn-cancel {
    padding: 0.5rem 1rem;
    background: #gray;
    color: #333;
    border: 1px solid #ddd;
    border-radius: 4px;
    cursor: pointer;
}

.hidden {
    display: none;
}
</style>

@push('scripts')
<script>
// Profile picture handling
document.getElementById('changePictureBtn').addEventListener('click', function() {
    document.getElementById('pictureInput').click();
});

document.getElementById('pictureInput').addEventListener('change', function() {
    const formData = new FormData(document.getElementById('pictureForm'));
    
    fetch('{{ route("profile.update-picture") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('currentProfilePicture').src = data.path;
            // Show success message
            alert('Profile picture updated successfully');
        }
    })
    .catch(error => {
        alert('Failed to update profile picture');
    });
});

// Profile edit modal handling
const modal = document.getElementById('editProfileModal');
const editBtn = document.querySelector('.btn-edit-info');
const closeBtn = document.querySelector('.modal-close');
const cancelBtn = document.querySelector('.btn-cancel');

function openModal() {
    modal.classList.remove('hidden');
}

function closeModal() {
    modal.classList.add('hidden');
}

editBtn.addEventListener('click', openModal);
closeBtn.addEventListener('click', closeModal);
cancelBtn.addEventListener('click', closeModal);

// Profile update handling
document.getElementById('editProfileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch('{{ route("profile.update") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update displayed information
            document.querySelector('[data-field="name"]').textContent = data.user.name;
            document.querySelector('[data-field="email"]').textContent = data.user.email;
            document.querySelector('.profile-titles h1').textContent = data.user.name;
            document.querySelector('.profile-titles .text-muted').textContent = data.user.email;
            
            closeModal();
            alert('Profile updated successfully');
        }
    })
    .catch(error => {
        alert('Failed to update profile');
    });
});
</script>
@endpush
@endsection