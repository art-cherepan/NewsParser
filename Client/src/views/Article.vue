<template>
  <div class="wrapper">
    <router-link to="/">Вернуться на главную</router-link>
    <div v-if="article" class="article">
      <Article :article="article"/>
    </div>
  </div>

</template>

<script>
  import Article from '@/components/Article'
  export default {
    props: [
        'id',
    ],
    computed: {
      article() {
        return this.$store.getters.getArticleById(parseInt(this.id));
      }
    },
    components: { Article }
  }
</script>

<style scoped>
.wrapper {
  width: 600px;
  margin-left: auto;
  margin-right: auto;
  margin-top: 50px;
}
</style>

