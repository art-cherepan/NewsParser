<template>
  <form @submit.prevent="submit">
    <input type="number" placeholder="Введите количество новостей на странице" v-model="count">
    <button type="submit">Обновить количество новостей</button>
    <hr>
  </form>
</template>

<script>
import {mapMutations} from 'vuex';

export default {
  data() {
    return {
      count: "",
    }
  },
  methods: {
    ...mapMutations(["createCount"]),
    submit() {
      this.createCount(this.count);
    }
  }
}
</script>

<style scoped>
form {
  width: 400px;
  margin-left: auto;
  margin-right: auto;
}
input {
  display: block;
  width: 100%;
  border: 1px solid black;
  border-radius: 2px;
  padding: 10px;
  margin-bottom: 10px;
}
</style>