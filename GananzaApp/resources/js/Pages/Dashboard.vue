<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Aside from '@/Components/Aside.vue';
import Header from '@/Components/Header.vue';
import LotteryCard from '@/Components/LotteryCard.vue';
import TrendsCard from '@/Components/TrendsCard.vue';
import BallotWidget from '@/Components/BallotWidget.vue';

</script>

<template>
  <div class="dashboard">
    <Aside />
    <div class="content">
     <Header/>
      <main class="main-content">
        <div class="column column1">
          <div class="container_colum_card">
            <LotteryCard logo="/path/to/lottery-logo.png" name="Mega Lotto"
              description="Details about Mega Lotto. Find out the latest draws, winnings, and more." />

            <LotteryCard logo="/path/to/lottery-logo.png" name="Mega Lotto"
              description="Details about Mega Lotto. Find out the latest draws, winnings, and more." />

            <LotteryCard logo="/path/to/lottery-logo.png" name="Mega Lotto"
              description="Details about Mega Lotto. Find out the latest draws, winnings, and more." />

            <LotteryCard logo="/path/to/lottery-logo.png" name="Mega Lotto"
              description="Details about Mega Lotto. Find out the latest draws, winnings, and more." />

            <LotteryCard logo="/path/to/lottery-logo.png" name="Mega Lotto"
              description="Details about Mega Lotto. Find out the latest draws, winnings, and more." />

            <LotteryCard logo="/path/to/lottery-logo.png" name="Mega Lotto"
              description="Details about Mega Lotto. Find out the latest draws, winnings, and more." />

              <LotteryCard logo="/path/to/lottery-logo.png" name="Mega Lotto"
              description="Details about Mega Lotto. Find out the latest draws, winnings, and more." />

              <LotteryCard logo="/path/to/lottery-logo.png" name="Mega Lotto"
              description="Details about Mega Lotto. Find out the latest draws, winnings, and more." />

              <LotteryCard logo="/path/to/lottery-logo.png" name="Mega Lotto"
              description="Details about Mega Lotto. Find out the latest draws, winnings, and more." />
              

              <LotteryCard logo="/path/to/lottery-logo.png" name="Mega Lotto"
              description="Details about Mega Lotto. Find out the latest draws, winnings, and more." />

             
              
          </div>
        </div>
        <div class="column column2">Columna 2
          <BallotWidget class ="item3"/>
          <TrendsCard class="widget trends"/>
        </div>

      </main>
    </div>
  </div>
</template>


<style scoped>
.dashboard {
  top: 0%;
  width: 100%;
  position: absolute;
  margin-top: 12%;
  display: flex;
  height:auto;
  background-color: #dcdcdc;

 
}

.content {
  margin-top: 5%;
  height: 110%;
  flex: 1;
  display: flex;
  flex-direction: column;
}

.main-content {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  padding: 20px;
  margin-left: 12%;
}

.column{ 
  margin: 0 10px;
  
}

.column1 {
width: 33%;

  
}

.column2{
  display: grid;
  grid-template-columns: repeat(2, 1fr); /* 2 columnas */
  grid-template-rows: 3; 
  gap: 10px;

  width: 60%;
}


.container_colum_card {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  grid-template-rows: 1; 
  gap: 20px;
 
}
.trends{
  grid-column: 1; 
  grid-row:  2 ; 
}


.item3 {
    grid-column: 1 / span 2; /* Ocupa columnas 1 y 2 */
    grid-row: 1; /* Ocupa la fila 1 */
}
</style>