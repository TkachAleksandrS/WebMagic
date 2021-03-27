<template>
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col"> #</th>
            <th scope="col"> Publication date</th>
            <th scope="col"> Title</th>
            <th scope="col"> Author</th>
            <th scope="col"> Tags</th>
        </tr>
        </thead>
        <tbody>
        <template v-if="articles.length">
            <tr v-for="(article, index) in articles" :key="article.id">
                <th scope="row">{{ getPosition(index) }}</th>
                <td>{{ article['published_at'] }}</td>
                <td>
                    <a :href="parseDomain + article['link']" target="_blank">
                        {{ article['title'] }}
                    </a>
                </td>
                <td>{{ article['author'] }}</td>
                <td>
                    <template v-for="(tag, index) in article['tags']">
                        <span :key="tag.id">{{ index ? ', ' + tag['name'] : tag['name'] }}</span>
                    </template>
                </td>
            </tr>
        </template>
        <tr v-if="!isLoading && articles.length === 0">
            <th colspan="6" class="text-center">
                <div> Data base empty </div>
                <button class="btn badge badge-success" type="button"
                        @click="() => $emit('parse')" :disabled="isLoading"
                >
                        load articles
                </button>
            </th>
        </tr>
        <tr>
            <th colspan="6" class="text-center">
                <loader :isShow="isLoading"/>
            </th>
        </tr>
        </tbody>
    </table>
</template>

<script>
import Loader from '@/components/Loader';

export default {
    name: "ArticleList",
    components: {
        Loader,
    },
    props: {
        data: {
            type: Object,
            default: {},
        },
        isLoading: {
            type: Boolean,
            default: false,
        },
    },
    data: () => ({
        parseDomain: process.env.MIX_PARSE_DOMAIN,
    }),
    computed: {
        articles() {
            return this.data.data ?? [];
        },
        paginate() {
            const {data, ...paginate} = this.data;
            return paginate ?? {};
        },
    },
    methods: {
        getPosition(index) {
            const p = this.paginate;

            return (index + 1) + (p.current_page * p.per_page) - p.per_page;
        },
    },
};
</script>

<style scoped>

</style>
