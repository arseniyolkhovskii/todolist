<script setup>
import {Link} from "@inertiajs/vue3";
import { usePage } from '@inertiajs/vue3';
import NavLink from "@/Components/NavLink.vue";

const { props } = usePage();
const auth = props.auth || {}; // Информация об авторизованном пользователе
const canLogin = props.canLogin;
const canRegister = props.canRegister;

</script>


<template>

    <div class="flex space-x-8 mt-4 justify-center ">
    <Link :href="route('tasks.index')" class="px-4 py-1.5 hover:bg-white hover:text-sky-400 border border-sky-400 text-lg  rounded-full bg-sky-400 text-center text-white">Список задач</Link>
    <Link :href="route('tasks.create')" class="px-4 py-1.5 hover:bg-white hover:text-green-400 border border-green-400 text-lg  rounded-full bg-green-400 text-center text-white">Добавить задачу</Link>
    <Link :href="route('categories.index')" class="px-4 py-1.5 hover:bg-white hover:text-sky-400 border border-sky-400 text-lg  rounded-full bg-sky-400 text-center text-white">Категории</Link>
    <Link :href="route('labels.index')" class="px-4 py-1.5 hover:bg-white hover:text-sky-400 border border-sky-400 text-lg  rounded-full bg-sky-400 text-center text-white">Метки</Link>
    </div>
    <div>
        <header class="text-white p-4 absolute top-3 right-5">
                <div v-if="canLogin" class="flex  space-x-8 justify-between">
                    <template v-if="auth.user">
                        <span class="inline-flex text-gray-800 rounded-md">
                                                {{ $page.props.auth.user.name }}
                        </span>
                    <Link
                        :href="route('profile.edit')"
                        class=" font-medium text-gray-800 hover:underline">
                        Личный кабинет
                    </Link>
                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="font-medium text-gray-800 hover:underline">
                        Выйти
                    </Link>
                    </template>
                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="font-medium text-gray-800 hover:underline ">
                            Войти
                        </Link>

                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="font-medium text-gray-800 hover:underline">
                            Регистрация
                        </Link>
                    </template>
                </div>
        </header>
    </div>
    <div class="w-1/4 mx-auto border-b pt-3 border-gray-300"></div>
    <slot />
</template>

<style scoped>

</style>
