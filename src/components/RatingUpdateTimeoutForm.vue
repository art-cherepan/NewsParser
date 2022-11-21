<template>
  <form @submit.prevent="pollData">
    <input type="number" placeholder="Введите время обновления данных в секундах" v-model="countOfMilliseconds">
    <button type="submit">Установить время обновления страницы</button>
    <hr>
  </form>
</template>

<script>
import {mapActions, mapMutations} from 'vuex';

export default {
  data() {
    return {
      countOfMilliseconds: "",
      polling: null,
    };
  },
  methods: {
    ...mapActions(["getNewsRating"]),
    ...mapMutations(["createCountOfMillisecondsForUpdate"]),
    pollData() {
      this.createCountOfMillisecondsForUpdate(this.countOfMilliseconds);
      this.polling = setInterval(() => {
        this.getNewsRating()
      }, this.countOfMilliseconds * 1000);
    },
  },
  computed: {

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