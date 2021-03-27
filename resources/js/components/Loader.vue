<template>
    <div class="d-flex justify-content-center align-items-center">
        <div v-if="isShow" class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</template>

<script>
export default {
    name: "Loader",
    props: {
        isShow: {
            type: Boolean,
            default: false,
        },
    },
};
</script>

<style scoped>

</style>
