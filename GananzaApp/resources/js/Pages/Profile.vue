<script setup>
import UserProfileCard from '@/Components/UserProfileCard.vue';
import Header from '@/Components/Header.vue';
import Aside from '@/Components/Aside.vue';
</script>

<template>
  <div class="profile-page">
    <div class="profile-content">
      <div class="profile-container">
        <UserProfileCard
          userName="Max Smith"
          userRole="Developer"
          userLocation="SF, Bay Area"
          userEmail="max@kt.com"
          userImage="https://via.placeholder.com/150"
          :isOnline="true"
        />
        <div class="profile-details">
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.profile-page {
  display: flex;
}

.profile-content {
  width: 100%;
  padding: 20px;
}

.profile-container {
  display: flex;
  gap: 20px;
}
</style>
