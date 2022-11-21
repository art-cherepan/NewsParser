<template>
  <div>
    <NewsCountForm/>

    <RatingUpdateTimeoutForm />

    <h1>Количество новостей: {{ newsCount }}</h1>

    <ArticleHome
        v-for="article in validNews" :key="article.id"
        v-bind:article="article"
    />

    <div v-if="validNews.length" v-observe-visibility="handle"></div>
  </div>

</template>

<script>
import { mapGetters, mapMutations } from 'vuex';
import { mapActions } from "vuex";
import ArticleHome from "@/components/ArticleHome";
import NewsCountForm from "@/components/NewsCountForm";
import RatingUpdateTimeoutForm from "@/components/RatingUpdateTimeoutForm";

export default {
  computed: {
    ...mapGetters(['validNews', 'newsCount']),
    updated: {

    }
  },
  components: { ArticleHome, NewsCountForm, RatingUpdateTimeoutForm },
  data () {
    return {
      news: [],
      index: 0,
      count: 4,
    }
  },
  methods: {
    ...mapActions(['fetchNews']),
    ...mapMutations(["removeArticle"]),

    handle (isVisible) {
      if (!isVisible) { return }
      this.fetchNews();
    },
    submit() {
      this.removeArticle(this.id);
    }
  },
  mounted() {
    this.fetchNews();
  }
}
</script>


<style scoped>
.article {
  border: 1px solid #ccc;
  border-radius: 5px;
  margin-bottom: 1rem;
}
</style>