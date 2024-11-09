<template> 
  <!-- Barra de búsqueda -->
  <div class="search-bar">
    <span class="icon"></span>
    <input 
      type="text" 
      placeholder="Find Goods" 
      v-model="searchQuery" 
      @focus="showModal = true" 
      @input="filterSearch" 
    />
  </div>

  <!-- Modal de búsqueda con transición -->
  <transition name="slide-down">
    <div v-if="showModal" class="modal-content" @click.stop>
      <h2>Recently Searched:</h2>
      <ul class="search-list">
        <li v-for="(item, index) in filteredResults" :key="index">
          <span>{{ item.name }}</span>
          <span class="item-id">{{ item.id }}</span>
        </li>
      </ul>
      <p v-if="filteredResults.length === 0">No results found</p>
    </div>
  </transition>
</template>

<script>
export default {
  data() {
    return {
      showModal: false,
      searchQuery: "",
      recentSearches: [
        { name: 'BoomApp by Keenthemes', id: '#45789' },
        { name: 'Kept API Project Meeting', id: '#84050' },
        { name: 'KPI Monitoring App Launch', id: '#84250' },
        { name: 'Project Reference FAQ', id: '#67945' },
        { name: 'FitPro App Development', id: '#84250' },
        { name: 'Shopix Mobile App', id: '#45690' }
      ],
      filteredResults: []
    };
  },
  mounted() {
    window.addEventListener('click', this.handleClickOutside);
    this.filteredResults = this.recentSearches;
  },
  beforeUnmount() {
    window.removeEventListener('click', this.handleClickOutside);
  },
  methods: {
    handleClickOutside(event) {
      const modal = document.querySelector('.modal-content');
      const searchBar = document.querySelector('.search-bar');
      
      // Verifica si el clic fue fuera del modal y de la barra de búsqueda
      if (
        this.showModal &&
        modal && searchBar &&
        !modal.contains(event.target) &&
        !searchBar.contains(event.target)
      ) {
        this.showModal = false;
      }
    },
    filterSearch() {
      const query = this.searchQuery.toLowerCase();
      this.filteredResults = this.recentSearches.filter(item => 
        item.name.toLowerCase().includes(query)
      );
    }
  }
};
</script>

<style scoped>
.search-bar {
  width: 55%;
  display: flex;
  align-items: center;
  padding: 10px;
  background-color: transparent transparent transparent;
  color: #d0d1d9;
  cursor: pointer;
  border-radius: 15px;
  border: 1px solid #ffdd00;
  position: relative;
}

.search-bar input {
  background: none;
  border: none;
  color: #d0d1d9;
  outline: none;
  width: 100%;
}

.icon {
  margin-right: 8px;
}

.modal-content {
  position: absolute;
  top: 60%;
  left: 55%;
  width: 18%;
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
