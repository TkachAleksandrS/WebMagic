<template>
    <div>
        <sort :disabled-btn="isLoading || !articles.length"
              @change="payload => getData('articles', ...payload)"
        />

        <article-list :data="data"
                      :is-loading="isLoading"
                      @parse="() => getData('parse')"
        />

        <pagination v-if="!isLoading"
                    :data="paginate"
                    :limit="1"
                    :show-disabled="true"
                    :align="'center'"
                    @pagination-change-page="page => getData('articles', page)"
        />
    </div>
</template>

<script>
import Sort from './Sort';
import ArticleList from './ArticleList';

import Pagination from 'laravel-vue-pagination';

export default {
    name: "Home",
    components: {
        Sort,
        ArticleList,
        Pagination,
    },
    data: () => ({
        data: {},
        paginate: {},
        articles: [],
        isLoading: false,
    }),
    created() {
        this.getData('articles');
    },
    methods: {
        async getData(action, page = 1, selected = {column: 'author', way: 'asc'}) {
            this.isLoading = true;
            let data = {};

            switch (action) {
                case 'articles':
                    data = await this.getArticles(page, selected)
                    break;

                case 'parse':
                    data = await this.parse();
                    break;
            }

            const {data: articles, ...paginate} = data;

            this.data = data;
            this.paginate = paginate;
            this.articles = articles;

            this.isLoading = false;
        },
        async getArticles(page, selected) {
            if (page === 1 && JSON.stringify(this.$route.query) !== JSON.stringify(selected)) {
                await this.$router.push({query: selected});
            }

            this.data = {};

            const {column, way} = this.$route.query;

            const {data} = await window.axios.get(`/articles?column=${column}&way=${way}&page=${page}`);

            return data;
        },
        async parse() {
            const {data} = await window.axios.get(`/parse`);

            return data;
        },
    },
}
</script>

<style scoped>

</style>
