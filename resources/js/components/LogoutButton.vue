<template>
    <a class="dropdown-item" :href="route" @click.prevent="logout">
        <slot/>
    </a>
</template>

<script>
    export default {
        props: {
            route: {
                type: String,
                default: "/logout"
            }
        },

        methods: {
            logout() {
                axios.post(this.route).then(response => {
                    window.location.href = response.request.responseURL
                });
            }
        }
    };
</script>
