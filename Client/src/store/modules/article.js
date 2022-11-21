import axios from "axios";

export default {
    state: {
        news: [],
        newsRating: [],
        flags: [],
        index: 0,
        count: 4,
        countOfMilliseconds: 3000,
        dataReceivedIn: false
    },
    getters: {
        validNews(state) {
            return state.news.filter(article => {
                return article.title && article.text;
            })
        },
        newsCount(state, getters) {
            return getters.validNews.length;
        },
        getArticleById: state => id => {
            return state.news.find(article => article.id === id);
        },
        getRatingById: state => id => {
            return state.newsRating.find(rating => rating.id === id);
        },
        getFlagById: state => id => {
            return state.flags.find(flag => flag.id === id);
        },
        getIndex(state) {
            return state.index;
        },
        getCount(state) {
            return state.count;
        },
        getDataReceivedIn(state) {
            return state.dataReceivedIn;
        },
    },
    actions: {
        async fetchNews(ctx) {
            const url = 'http://localhost:8000/news/?index=' + ctx.getters.getIndex + '&count=' + ctx.getters.getCount;
            const news = await axios.get(url);
            if (!ctx.getters.getDataReceivedIn) {
                ctx.commit('updateNews', news);
            }
        },
        async getNewsRating(ctx) {
            const url = 'http://localhost:8000/news/get-rating/';
            const newsRating = await axios.get(url);
            ctx.commit('updateNewsRating', newsRating);
        },
        async updateRatingInDb(ctx, obj) {
            console.log('ggg: ' + obj.rating);
            const url = 'http://localhost:8000/news/' + obj.articleId + '/' + obj.rating + '/update-rating/';
            await axios.get(url);
        }
    },
    mutations: {
        updateNews(state, news) {
            state.news.push(...news.data.data);
            state.newsRating.push(...news.data.data);

            const flags = [];
            state.news.forEach(function(article) {
                const obj = {
                  'id': article.id,
                  'flag': null,
                };
                flags.push(obj);
            });

            state.flags.push(...flags);

            if (news.data.lastDataPortion) {
                state.dataReceivedIn = true;
            } else {
                state.index = news.data.data[state.count - 1].id;
            }
        },
        updateNewsRating(state, newsRating) {
            state.news.forEach(function (articleOld) {
                newsRating.data.forEach(function (articleNew) {
                    if (articleOld.id === articleNew.id) {
                        if (articleOld.rating < articleNew.rating) {
                            state.flags.forEach(function (obj) {
                                if (obj.id === articleOld.id) {
                                    obj.flag = 2;
                                }
                            })
                        } else if (articleOld.rating > articleNew.rating) {
                            state.flags.forEach(function (obj) {
                                if (obj.id === articleOld.id) {
                                    obj.flag = 1;
                                }
                            })
                        } else if (articleOld.rating === articleNew.rating) {
                            state.flags.forEach(function (obj) {
                                if (obj.id === articleOld.id) {
                                    obj.flag = 0;
                                }
                            })
                        }
                    }
                })
            });

            state.news.forEach(function (articleOld) {
                newsRating.data.forEach(function (articleNew) {
                    if (articleOld.id === articleNew.id) {
                        articleOld.rating = articleNew.rating;
                    }
                })
            });
        },
        createCount(state, count) {
            state.count = count;
        },
        createCountOfMillisecondsForUpdate(state, countOfMilliseconds) {
            state.countOfMilliseconds = countOfMilliseconds;
        },
        removeArticle(state, id) {
            const indexObj = state.news.findIndex(obj => { return obj.id === id });
            state.news.splice(indexObj, 1);
        },
    }
}