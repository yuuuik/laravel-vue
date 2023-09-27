<template>
    <div>
        <p v-if="$page.props.message" class="bg-indigo-600 h-10 flex items-center justify-center text-sm font-medium text-white px-4 sm:px-6 lg:px-8">
            {{ $page.props.message }}
        </p>

        <nav class="bg-gray-800">
            <div class="max-w-7xl mx-auto">
                <div class="relative flex items-center justify-between h-16">
                    <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                        <div class="flex space-x-4">
                            <a :href="route('home')" :class="{[activeClass]: isActive('home')}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                                Home
                            </a>
                            <a :href="route('users.index')" :class="{[activeClass]: isActive('users')}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                                Users
                            </a>
                            <a :href="route('articles.index')" :class="{[activeClass]: isActive('users')}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                                Articles
                            </a>
                            <a :href="route('categories.index')" :class="{[activeClass]: isActive('categories')}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                                Categories
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div v-if="$page.props.user">
            <div class="flex items-center">
                <img
                    v-if="$page.props.user.avatar_path"
                    :src="`/storage/${$page.props.user.avatar_path}`"
                alt="Avatar"
                class="h-10 w-10 rounded-full mr-2"
                />
                <div>
                    <p class="text-sm font-medium">{{ $page.props.user.name }}</p>
                    <p class="text-xs font-medium text-gray-500">{{ $page.props.user.email }}</p>
                </div>
            </div>
            <div>
                <a @click="logout">Выйти</a>
            </div>
        </div>

        <div class="container mx-auto">
            <div class="my-10">
                <slot />
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'

export default {
    components: {
        Link
    },
    data: () => ({
        activeClass: 'text-blue-500'
    }),
    methods: {
        isActive(route) {
            return this.route().current() === route || this.route().current().includes(route);
        },
        logout() {
            this.$inertia.delete(route('logout'))
        }
    }
};
</script>
