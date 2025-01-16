<script>
import {Link} from "@inertiajs/vue3";
import TaskLayout from "@/Layouts/TaskLayout.vue";
import {Slider} from "@ckpack/vue-color";
export default {
    name: "Edit",
    components: {'slider-picker': Slider, TaskLayout, Link},
    props: [
        'label',
        'errors'
    ],

    data() {
        return {
            id: this.label.id,
            title: this.label.title,
            color: this.label.color,
        }
    },
    methods: {
        update() {
           this.$inertia.patch(`/labels/${this.id}`, {title: this.label.title, color: this.label.color.hex,})
        },
    },

}

</script>

<template>
    <TaskLayout>
    <div class="w-96 mx-auto pt-5">
        <h1 class="text-lg mb-5 text-center">Редактирование Метки</h1>
    <form @submit.prevent="update">
        <div class="mb-6 mb-2 block border-t pt-7 border-gray-300">
        <label class="mb-2 block">Название метки</label>
        <input v-model="label.title" class="w-full rounded-full border-sky-400" type="text">
            <div v-if="errors.title" class="text-red-600 mt-2 ml-3">{{ errors.title }}</div>
        </div>
        <p >Выбранный цвет: <div
            class="mt-3 h-12 w-12 ml-1 rounded-full "
            :style="{ backgroundColor: label.color }"
        >
        </div></p>
        <div class="mt-6"><label>Изменить цвет метки:</label>
            <slider-picker class="mb-5 mt-4" v-model="label.color" />

            <div v-if="errors.color" class="text-red-600 mt-2 ml-3">{{ errors.color }}</div>
        </div>
        <button class="hover:bg-white hover:text-sky-400 border border-sky-400 block py-2 px-4 mt-10 w-55 ml-auto rounded-full bg-sky-400 text-center text-white" type="submit">Обновить метку</button>
    </form>
    </div>
    </TaskLayout>
</template>

<style scoped>

</style>
