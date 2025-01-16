<script>
import {Link} from "@inertiajs/vue3";
import TaskLayout from "@/Layouts/TaskLayout.vue";
import Multiselect from "vue-multiselect";
export default {
    name: "Edit",
    components: {Multiselect, TaskLayout, Link},
    props: {
        task: Object,
        categories: Array,
        labels: Array,
        errors: Object,
    },
mounted() {
    console.log(this.task.category_id);
},
    data() {
        return {
            id: this.task.id,
            title: this.task.title,
            description: this.task.description,
            options: [],
            is_completed: this.task.is_completed,
            selectedLabels: this.task.labels,
            category_id: this.task.category_id ?? ""
        }
    },
    created() {
        this.options = this.labels.map(label => ({
            id: label.id,
            name: label.title,
            color: label.color,
        }));
        this.selectedLabels = this.task.labels.map(label => ({
            id: label.id,
            name: label.title,
            color: label.color,
        }));
    },
    methods: {
        update() {
           this.$inertia.patch(`/tasks/${this.id}`, {
               title: this.task.title,
               description: this.task.description,
               category_id: this.task.category_id,
               is_completed: this.task.is_completed ? 1 : 0,
               selectedLabels: this.selectedLabels,
           })
        },
    },
    }

</script>
<template>
    <TaskLayout>
    <div class="w-96 mx-auto pt-5">
        <h1 class="text-lg mb-10 text-center border-b pb-5 border-gray-300">Редактирование задачи</h1>
    <form @submit.prevent="update">
        <div class="mb-10">
        <label class="mb-2 block">Название Задачи</label>
        <input v-model="task.title" class="w-full rounded-full border-sky-400" placeholder="Название" type="text">
            <div v-if="errors.title" class="text-red-600 mt-2">{{ errors.title }}</div>
        </div>
        <div class="mb-5">

            <div class="flex items-center space-x-2">
                <label class="mb-2 block">Описание Задачи</label>
                <p class="text-xs text-gray-400 italic">(не обязательно)</p>
            </div>
        <textarea  v-model="task.description"  class="w-full rounded-3xl border-sky-400  overflow-hidden"  placeholder="Описание"></textarea>
        </div>
        <div class="mb-8">
            <label for="category" class="block text-gray-700 mb-2">Выберите категорию</label>
            <select v-model="task.category_id" id="category" class="w-full rounded-full bg-white border border-sky-400">
                <option value="">
                    Без категории
                </option>
                <option v-for="category in categories" :key="category.id" :value="category.id">
                    {{ category.title }}
                </option>
            </select>
        </div>
        <div>
        <div class="flex items-center space-x-2"><label class="mb-2 block">Выберите метки</label>
            <p class="text-xs text-gray-400 italic">(не обязательно)</p>
        </div>
            <multiselect
                v-model="selectedLabels"
                :options="options"
                class="custom-multiselect"
                label="name"
                multiple
                :searchable="false"
                track-by="id"
                placeholder="Выберите метки">
                <template #option="props">
                    <div class="flex items-center">
                        <div class="w-4 h-4 rounded-full mr-2" :style="{ backgroundColor: props.option.color }"></div>
                        <span>{{ props.option.name }}</span>
                    </div>
                </template>
            </multiselect>
        </div>
        <div class="mt-5">
        <label  for="is_completed">Выполнена задача?</label>
            <div class="flex items-center">
            <input v-model="task.is_completed" :true-value="1" :false-value="0" id="is_completed" class="ml-2 mt-3 mb-5  block rounded-full border-sky-400 text-sky-400 shadow-sm  focus:ring-white"  type="checkbox"/>
            <span class="ml-5 mb-2" :class="task.is_completed ? 'text-green-600' : 'text-red-600'">
        {{ task.is_completed ? 'Выполнена!' : 'Не выполнена' }}
                <span class="text-lg mb-1.5" v-html="task.is_completed == 1 ? '<i class=\'fas fa-check-circle text-green-500 ml-3\'></i>' : '<i class=\'fa-solid fa-circle-xmark text-red-500 ml-3\'></i>'"></span>

    </span>
            </div>
        </div>
        <button class="hover:bg-white hover:text-sky-400 border border-sky-400 block p-2 w-40 ml-auto rounded-full bg-sky-400 text-center text-white" type="submit">Обновить задачу</button>
    </form>
    </div>
    </TaskLayout>
</template>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style scoped>
textarea::-webkit-resizer {
    background-color: #21c2fc;
    border-radius: 8px;
}
.custom-multiselect {
    border: 1px solid #21c2fc;
    border-radius: 10px;
    padding: 1px;
}

</style>
