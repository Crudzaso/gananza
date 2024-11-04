<template>
    <div class="user-profile-card">
      <div class="profile-picture">
        <img :src="userImage" alt="User Profile" />
        <span class="status-indicator" :class="{ online: isOnline }"></span>
      </div>
      <div class="user-info">
        <h2>{{ userName }}</h2>
        <p>{{ userRole }}</p>
        <p>{{ userLocation }}</p>
        <p>{{ userEmail }}</p>
      </div>
      <div class="profile-buttons">
        <button class="follow-btn">Follow</button>
        <button class="hire-btn">Hire Me</button>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: "UserProfileCard",
    props: {
      userName: {
        type: String,
        default: "Max Smith"
      },
      userRole: {
        type: String,
        default: "Developer"
      },
      userLocation: {
        type: String,
        default: "SF, Bay Area"
      },
      userEmail: {
        type: String,
        default: "max@kt.com"
      },
      userImage: {
        type: String,
        default: "https://via.placeholder.com/150"
      },
      isOnline: {
        type: Boolean,
        default: true
      }
    }
  };
  </script>
  
  <style scoped>
  .user-profile-card {
    display: flex;
    flex-direction: row;
    width: 100%;
    height: 35vh;
    display: flex;
    align-items: center;
    background-color: white;
    border-radius: 10px;
    padding: 15px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
  }
  
  .profile-picture {
    position: relative;
    margin-right: 15px;
  }
  
  .profile-picture img {
    border-radius: 50%;
    width: 80px;
    height: 80px;
  }
  
  .status-indicator {
    position: absolute;
    bottom: 5px;
    right: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: #f00;
  }
  
  .status-indicator.online {
    background-color: #0f0;
  }
  
  .user-info {
    flex-grow: 1;
  }
  
  .profile-buttons {
    display: flex;
    gap: 10px;
  }
  
  .follow-btn,
  .hire-btn {
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    color: white;
  }
  
  .follow-btn {
    background-color: #6c757d;
  }
  
  .hire-btn {
    background-color: #007bff;
  }
  </style>
  