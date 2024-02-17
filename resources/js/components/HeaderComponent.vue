<template>
  <header class="header">
    <div class="header__wrapper">
      <nav class="header__menu">
          <router-link to="/">Upload</router-link>
          <router-link to="/users">Users</router-link>
          <router-link to="/create">Create</router-link>
      </nav>
    </div>
  </header>
</template>

<style scoped>
  .header{
    margin-top: 15px;
  }

  .header__menu{
    display: flex;
    align-items: center;
    justify-content: center;
    column-gap: 20px;
  }

  .header__menu a{
    border-radius: 2px;
    padding: 5px 15px;
    background-color: #2f2f2f;
    box-shadow:0 1px 2px rgba(0, 0, 0, .04), 0 1px 2px rgba(0, 0, 0, .06);
    font-weight: 700;
    font-size: 18px;
    color: #aac8e4;
    transition: .2s;
  }

  .header__menu a:hover{
    background-color: #3a3a3a;
    color: #2d9164;
  }
</style>
