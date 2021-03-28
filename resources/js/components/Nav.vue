<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-3 border-bottom shadow-sm">
        <div class="collapse navbar-collapse container">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <router-link :class="['nav-link', {'active': $route.path === '/'}]" :to="{name: 'home'}">
                        Articles
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link :class="['nav-link', {'active': $route.path === '/tags'}]" :to="{name: 'tags'}">
                        Tags
                    </router-link>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
export default {
    name: "Nav",
};
</script>

<style scoped>

</style>
