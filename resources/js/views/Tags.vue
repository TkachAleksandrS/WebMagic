<template>
    <div>
        <ul class="list-group shadow-sm">
            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold bg-dark text-white rounded-0">
                <div> Name </div>
                <div> ID </div>
            </li>
            <template v-if="!isLoading">
                <li class="list-group-item d-flex justify-content-between align-items-center"
                    v-for="tag in tags" :key="tag.id">
                    {{ tag.name }}
                    <span class="badge badge-primary badge-pill">{{ tag.id }}</span>
                </li>
            </template>
            <li v-else class="list-group-item d-flex justify-content-center align-items-center">
                <loader :isShow="isLoading"/>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "Tags.vue",
    data: () => ({
        isLoading: true,
    }),
    async created() {
        this.isLoading = true;
        await this.$store.dispatch('tags/fetchTags');
        this.isLoading = false;
    },
    computed: {
        tags() {
            return this.$store.getters['tags/tags'];
        },
    },
};
</script>

<style scoped>

</style>
