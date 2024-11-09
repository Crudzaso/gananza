<template>
  <aside class="sidebar">
    <div class="logo">
      <!-- Logo -->
      <img src="/path/to/logo.png" alt="Logo" />
    </div>
    <nav class="nav">
      <ul>
        <li class="nav-item" v-for="(item, index) in navItems" :key="index">
          <div class="icon-menu-container">
            <!-- SVG Icon -->
            <svg
              width="40"
              height="40"
              viewBox="0 0 24 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
              class="icon"
            >
              <!-- Puedes poner cualquier SVG aquí -->
              <rect x="2" y="2" width="20" height="20" stroke="#888" stroke-width="2" />
            </svg>
            <div class="menu">
              <h3>{{ item.title }}</h3>
              <ul>
                <li v-for="(subItem, subIndex) in item.subItems" :key="subIndex">
                  {{ subItem }}
                </li>
              </ul>
            </div>
          </div>
        </li>
      </ul>
    </nav>
  </aside>
</template>

<script>
export default {
  data() {
    return {
      navItems: [
        { title: "User Profile", subItems: ["Edit Profile", "Settings"] },
        { title: "Account", subItems: ["Billing", "Subscriptions"] },
        { title: "Authentication", subItems: ["Login", "Register"] },
        { title: "Corporate", subItems: ["About Us", "Careers"] },
      ],
    };
  },
};
</script>

<style scoped>
.sidebar {
  width: 200px;
  height: 100%; /* Para que ocupe toda la altura de la pantalla */
  background-color: #ffffff;
  padding-top: 20px;
  display: flex;
  flex-direction: column;
  align-items: center;
  border-right: 1px solid #ffdd00;
  position: fixed; /* Hace que la barra lateral sea fija */
  top: 0; /* Asegura que esté pegada al borde superior */
  left: 0;
  z-index: 1000; /* Asegura que esté por encima de otros elementos */
}

.logo img {
  width: 50px;
  height: 50px;
  margin-bottom: 20px;
}

.nav ul {
  list-style: none;
  padding: 0;
  margin: 0;
  margin-top: 20vh; 
  width: 100%;
}

.nav-item {
  position: relative;
  width: 100%;
  margin-top: 35px; 
  height: 60px;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
}

.icon-menu-container {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
}

.icon {
  transition: fill 0.3s;
  fill: #888;
  width: 40px;
  height: 40px;
}

.nav-item:hover .icon,
.icon-menu-container:hover .icon {
  fill: #2c2e83;
}

.menu {
  display: none;
  position: absolute;
  left: 40px;
  top: 0;
  background-color: white;
  box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
  border-radius: 8px;
  padding: 20px;
  width: 200px;
  z-index: 10;
}

.icon-menu-container:hover .menu {
  display: block;
}

.menu h3 {
  margin: 0;
  font-size: 16px;
  font-weight: bold;
}

.menu ul {
  list-style: none;
  padding: 0;
  margin: 10px 0 0 0;
}

.menu li {
  font-size: 14px;
  margin: 8px 0;
  color: #555;
}
</style>
