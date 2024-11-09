<template>
    <div class="trends-card">
      <h3>Trends</h3>
      <p>Latest trends</p>
      <canvas ref="chartCanvas" class="chart"></canvas>
      <div class="top-authors">
        <h4>Top Authors</h4>
        <ul>
          <li v-for="(author, index) in topAuthors" :key="index">
            <img :src="author.logo" alt="Author Logo" />
            <span>{{ author.name }}</span>
            <span>+{{ author.apuestas }}</span>
          </li>
        </ul>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, nextTick } from 'vue';
  import { Chart, registerables } from 'chart.js';
  
  Chart.register(...registerables);
  
  const topAuthors = ref([
    { name: 'Ricky Hunt', logo: 'path/to/logo1.png', apuestas: 82 },
    { name: 'Sandra Trepp', logo: 'path/to/logo2.png', apuestas: 98 },
    { name: 'Author 3', logo: 'path/to/logo3.png', apuestas: 65 },
    { name: 'Author 4', logo: 'path/to/logo4.png', apuestas: 60 },
  ]);
  
  const chartData = [15, 30, 45, 20, 50]; // Simulación de datos de la gráfica
  
  const chartCanvas = ref(null);
  
  onMounted(async () => {
    await nextTick(); 
    const ctx = chartCanvas.value.getContext('2d');
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
        datasets: [{
          label: 'Apuestas',
          data: chartData,
          borderColor: '  #F5F11DFF',
          borderWidth: 2,
          fill: false,
        }],
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
          },
        },
      },
    });
  });
  </script>
  
  <style scoped>
  .trends-card {
    background: rgb(255, 255, 255);
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }
  
  .chart {
    max-width: 100%;
    height: 200px;
  }
  
  .top-authors {
    margin-top: 20px;
  }
  
  .top-authors ul {
    list-style: none;
    padding: 0;
  }
  
  .top-authors li {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin: 10px 0;
  }
  
  .top-authors img {
    width: 20px;
    height: 20px;
    margin-right: 10px;
  } 
  </style>
  