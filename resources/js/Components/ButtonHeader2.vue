<template>
    <!-- Barra de búsqueda -->
    <div @click="toggleModal" class="search-bar">
      <span class="icon"></span>
    </div>
  
    <!-- Modal de búsqueda con transición -->
    <transition name="slide-down">
      <div v-if="showModal" class="modal-content" @click.stop>
        <h2>Recently Searched:</h2>
        <ul class="search-list">
          <li v-for="(item, index) in recentSearches" :key="index">
            <span>{{ item.name }}</span>
            <span class="item-id">{{ item.id }}</span>
          </li>
        </ul>
      </div>
    </transition>
  </template>
  
  <script>
  export default {
    data() {
      return {
        showModal: false,
        recentSearches: [
          { name: 'BoomApp by Keenthemes', id: '#45789' },
          { name: 'Kept API Project Meeting', id: '#84050' },
          { name: 'KPI Monitoring App Launch', id: '#84250' },
          { name: 'Project Reference FAQ', id: '#67945' },
          { name: 'FitPro App Development', id: '#84250' },
          { name: 'Shopix Mobile App', id: '#45690' }
        ]
      };
    },
    mounted() {
      document.addEventListener('click', this.handleClickOutside);
    },
    beforeUnmount() {
      document.removeEventListener('click', this.handleClickOutside);
    },
    methods: {
      toggleModal() {
        this.showModal = !this.showModal;
      },
      handleClickOutside(event) {
        const modal = this.$el.querySelector('.modal-content');
        const searchBar = this.$el.querySelector('.search-bar');
        
        // Verificamos si el clic fue fuera del modal y de la barra de búsqueda
        if (
          this.showModal &&
          !modal.contains(event.target) &&
          !searchBar.contains(event.target)
        ) {
          this.showModal = false;
        }
      }
    }
  };
  </script>
  
  <style scoped>
  .search-bar {
    margin-left: 5%;
    width: 11%;
    display: flex;
    align-items: center;
    padding: 10px;
    background-color: #162263;
    color: #d0d1d9;
    cursor: pointer;
    border-radius: 15px;
    position: relative;
  }
  
  .icon {
    margin-right: 8px;
  }
  
  .modal-content {
    position: absolute;
    top: 60%; /* Justo debajo de la barra de búsqueda */
    left: 61%;
    width: 20%;
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
    z-index: 10;
    transform-origin: top;
  }
  
  /* Lista de búsquedas recientes */
  .search-list {
    list-style: none;
    padding: 0;
    margin: 0;
  }
  
  .search-list li {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid #e0e0e0;
  }
  
  .item-id {
    color: #888;
    font-size: 0.9em;
  }
  
  /* Transición de deslizamiento hacia abajo */
  .slide-down-enter-active,
  .slide-down-leave-active {
    transition: opacity 0.3s ease, transform 0.3s ease;
  }
  
  .slide-down-enter, .slide-down-leave-to {
    opacity: 0;
    transform: translateY(-20px);
  }
  </style>
  