<template>
    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="column"> Column </label>
            <select id="column" class="form-control form-control-sm" name="column" v-model="selected.column">
                <option v-for="item in sort.column" :key="item">{{ item }}</option>
            </select>
        </div>
        <div class="form-group col-md-5">
            <label for="way"> Way </label>
            <select id="way" class="form-control form-control-sm" name="way" v-model="selected.way">
                <option v-for="item in sort.way" :key="item">{{ item }}</option>
            </select>
        </div>
        <div class="form-group col-md-2 d-flex justify-content-center align-items-end">
            <button type="submit" class="btn btn-sm btn-primary w-100"
                    @click="() => $emit('change', [1, selected])"
                    :disabled="disabledBtn"
            >
                Sort
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: "Sort",
    props: {
        disabledBtn: {
            type: Boolean,
            default: true
        }
    },
    data: () => ({
        sort: {
            column: ['author', 'title'],
            way: ['asc', 'desc'],
        },
        selected: {
            column: 'author',
            way: 'asc',
        },
    }),
}
</script>

<style scoped>

</style>
