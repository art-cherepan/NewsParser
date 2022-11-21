import {createRouter, createWebHashHistory} from "vue-router";
import Home from "@/views/Home";
import Article from "@/views/Article";

export default createRouter({
    history: createWebHashHistory(),
    routes: [
        {
            path: '/',
            component: Home,
            name: 'home'
        },
        {
            path: '/article/:id',
            component: Article,
            name: 'article',
            props: true
        },
    ]
})
