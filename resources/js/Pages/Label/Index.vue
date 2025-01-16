<script>
import {Link} from "@inertiajs/vue3";
import TaskLayout from "@/Layouts/TaskLayout.vue";

export default {
    name: "Index",
    components: {TaskLayout, Link},
    props: {pagination: Object, labels: Array},
    methods: {
        deleteCategory(id) {
            this.$inertia.delete(`/labels/${id}`)
        },
        confirmDelete(id) {
            if (confirm('Вы уверены, что хотите удалить эту метку? Задачи с выбранными метками не удаляются')) {
                this.deleteCategory(id);
            }
        },
        fetchPage(page) {
            this.$inertia.get('/labels', {page: page});
        },
    }
}

</script>

<template>
    <TaskLayout>
        <div class="w-96 mx-auto pt-5">
            <div class="flex items-center justify-between">
                <h1 class="text-lg  text-center">Список меток</h1>
                <Link :href="route('labels.create')"
                      class="px-3 py-1 hover:bg-white hover:text-sky-400 border border-sky-400 rounded-full bg-sky-400 text-center text-white">
                    Добавить метку
                </Link>
            </div>
            <div class="mt-5" v-if="labels && labels.length > 0">
                <div class="mt-2 pt-4 border-t border-gray-300" v-for="label in labels">
                    <div class="text-center  text-2xl mb-5 break-words"> {{ label.title }}</div>
                    <div class="mb-5 mt-1 flex"><span class="text-sm  mr-2 text-slate-500">Цвет метки:</span><span
                        class="text-sm text-gray-700">
                        <div class="h-6 w-6   rounded-full" :style="{ backgroundColor: label.color }"></div></span></div>
                    <div class="flex justify-between mb-1 text-sm text-right">
                        <Link class="hover:text-sky-300 text-sky-500" :href="route('labels.show', label)">
                            Подробнее...
                        </Link>
                        <Link class="hover:text-sky-300 text-sky-500" :href="route('labels.edit', label)">
                            Редактировать
                        </Link>
                    </div>
                    <div class="flex justify-between mb-3 text-sm text-right">
                            <Link class="hover:text-sky-300  text-sky-500" :href="route('labels.showTasks', label.id)">
                                Задачи с этой меткой
                            </Link>
                            <p @click="confirmDelete(label.id)" class="cursor-pointer hover:text-red-400 text-red-600">
                                Удалить</p>
                    </div>
                </div>
            </div>
            <div v-else>
                <h1 class="text-xl text-center mt-5 pt-4 border-t border-gray-300">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i> Пока что нет ни одной метки!
                </h1>
            </div>
        </div>
        <div v-if="pagination.last_page > 1" class="pagination-wrapper mb-10 mt-10 flex justify-center">
            <ul class="flex space-x-2">
                <li v-if="pagination.current_page > 1" class="page-item">
                    <a href="#"
                       @click.prevent="fetchPage(pagination.current_page - 1)"
                       class="page-link inline-flex items-center px-4 py-2 border text-sm font-medium text-gray-700 bg-white border-gray-300 rounded-md hover:bg-gray-50">
                        Предыдущая
                    </a>
                </li>
                <li v-for="page in pagination.last_page"
                    :key="page"
                    :class="{ 'active': page === pagination.current_page }">
                    <a v-if="page !== pagination.current_page" href="#" @click.prevent="fetchPage(page)"
                       class="page-link inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md text-blue-500 border-gray-300 hover:bg-gray-50">{{ page }}</a>
                    <span v-else aria-current="page"
                          class="inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md bg-blue-500 text-white cursor-default">{{ page }}</span>
                </li>
                <li v-if="pagination.current_page < pagination.last_page" class="page-item">
                    <a href="#" @click.prevent="fetchPage(pagination.current_page + 1)"
                       class="page-link inline-flex items-center px-4 py-2 border text-sm font-medium text-gray-700 bg-white border-gray-300 rounded-md hover:bg-gray-50">
                        Следующая
                    </a>
                </li>
            </ul>
        </div>
    </TaskLayout>
</template>

<style scoped>

</style>

