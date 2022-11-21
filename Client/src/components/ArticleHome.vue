<template>
  <div class="article" v-bind:class="{ratingUp: ratingUp, ratingDown: ratingDown, ratingEqual: ratingEqual}">

    <h1>{{ article.title }}</h1>
    <p>{{ article.text }}</p>

    <router-link :to="{ name: 'article', params: { id: article.id } }">Ссылка на новость</router-link>

    <form @submit.prevent="remove">
      <button type="submit">Удалить новость</button>
    </form>

    <form @submit.prevent="updateRating">
      <input type="number" placeholder="рейтинг" v-model="articleRating">
      <button type="submit">Обновить рейтинг</button>
    </form>

  </div>

</template>

<script>
import {mapActions, mapMutations} from "vuex";

export default {
  props: ['article'],
  data() {
    return {
      id: this.article.id,
      articleRating: "",
    }
  },
  computed: {
    ratingUp() {
      console.log('up ' + this.$store.getters.getFlagById(parseInt(this.id)).flag);
      return this.$store.getters.getFlagById(parseInt(this.id)).flag === 2;
    },
    ratingDown() {
      return this.$store.getters.getFlagById(parseInt(this.id)).flag === 1;
    },
    ratingEqual() {
      return this.$store.getters.getFlagById(parseInt(this.id)).flag === 0;
    }
  },
  methods: {
    ...mapActions(["updateRatingInDb"]),
    ...mapMutations(["removeArticle"]),
    remove() {
       this.removeArticle(this.id);
    },
    updateRating() {
      this.updateRatingInDb({articleId: this.id, rating: this.articleRating});
    }
  },
}
</script>

<style scoped>
  .article {
    width: 450px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 1rem;
    padding: 10px;
    margin-left: auto;
    margin-right: auto;
  }
  form {
    margin: 10px;
  }
  input {
    width: 100px;
    border: 1px solid black;
    padding: 3px;
    border-radius: 2px;
    margin-bottom: 10px;
    margin-right: 10px;
  }
  .ratingUp {
    background-color: limegreen;
  }
  .ratingDown {
    background-color: indianred;
  }
  .ratingEqual {
    background-color: white;
  }
</style>