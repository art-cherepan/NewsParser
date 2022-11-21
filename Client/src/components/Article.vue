<template>
  <div class="wrapper">
    <h1>{{ article.title }}</h1>

    <img :src="article.imageHtml">

    <div class="article"> {{ article.text }}</div>
  </div>
</template>

<script>
  export default {
    props: {
      article: {
        type: Object,
        required: true
      }
    }
  }
</script>

<style scoped>
.wrapper {
  width: 700px;
  text-align: center;
}
.article {
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: x-large;
  padding: 10px;
  margin-top: 30px;
}
</style>