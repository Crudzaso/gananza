<template>
    <div class="lottery-card" @click="openModal">
      <img :src="logo" alt="Lottery Logo" class="lottery-logo">
      <span class="lottery-name">{{ name }}</span>
  
      <!-- Modal de información de la lotería -->
      <transition name="fade">
        <div v-if="showModal" class="modal-background" @click="closeModal">
          <div class="modal-content" @click.stop>
            <button class="close-button" @click="closeModal">Close</button>
            <h2>{{ name }} Details</h2>
            <p>{{ description }}</p>
          </div>
        </div>
      </transition>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      logo: {
        type: String,
        required: true
      },
      name: {
        type: String,
        required: true
      },
      description: {
        type: String,
        required: true
      }
    },
    data() {
      return {
        showModal: false
      };
    },
    methods: {
      openModal() {
        this.showModal = true;
      },
      closeModal() {
        this.showModal = false;
      }
    }
  };
  </script>
  
  <style scoped>
  .lottery-card {
    width: 100%;
    padding: 20px;
    background-color: #ffffff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    align-items: center;
    cursor: pointer;
    transition: transform 0.2s;
  }
  .lottery-card:hover {
    transform: translateY(-5px);
    border: 1px solid #ffdd00;

  }
  .lottery-logo {
    width: 50px;
    height: 50px;
    margin-bottom: 10px;
  }
  .lottery-name {
    font-weight: bold;
    color: #333;
    text-align: center;
  }
  
  /* Modal styles */
  .modal-background {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
  }
  
  .modal-content {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 8px;
    width: 300px;
    text-align: center;
    position: relative;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
  }
  
  .close-button {
    position: absolute;
    top: 10px;
    right: 10px;
    background: none;
    border: none;
    font-size: 1.2em;
    cursor: pointer;
  }
  
  /* Transition effects */
  .fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s;
  }
  .fade-enter, .fade-leave-to {
    opacity: 0;
  }
  </style>
  