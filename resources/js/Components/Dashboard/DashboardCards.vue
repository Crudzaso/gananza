<template>
    <div class="dashboard-cards">
      <div class="card" v-for="(stat, index) in stats" :key="index">
        <div class="card-content">
          <h4>{{ stat.title }}</h4>
          <p>{{ stat.value }}</p>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'DashboardCards',
    props: {
      stats: Array,
    },
  };
  </script>
  
  <style scoped>
  .dashboard-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
  }
  
  .card {
    background: var(--card-background);
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s;
  }
  
  .card:hover {
    transform: scale(1.05);
  }
  
  .card-content {
    text-align: center;
  }
  
  h4 {
    color: var(--text-primary);
    margin-bottom: 10px;
  }
  
  p {
    font-size: 1.5rem;
    font-weight: bold;
    color: var(--primary);
  }
  </style>
  