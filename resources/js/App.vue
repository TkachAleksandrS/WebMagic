<template>
    <div>
        <base-nav/>
        <router-view class="container"/>
    </div>
</template>

<script>
import BaseNav from '@/components/Nav';

export default {
    name: "App",
    components: {
        BaseNav,
    },
};
</script>

<style scoped>

</style>
