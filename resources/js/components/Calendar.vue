<template>
    <div class="container">
        CALENDAR: {{ $store.state.activeSidebar }}
        <div class="row justify-content-center">
            <p>{{ attrs.dates }}</p>
            <vc-date-picker
            v-model="attrs.dates"
            :max-date="new Date()"
            :attributes='attrs'
            :value="null"
            color="red"
            is-dark
            is-range
            is-expanded
            />
        </div>

    </div>
</template>

<script>
    export default {
        mounted() {
            console.log(this.attrs.dates)
        },
        data() {
            return {
                attrs: [
                    {
                    key: 'today',
                    highlight: {
                        color: 'orange',
                        fillMode: 'light',
                    },
                    dates: new Date(),
                    },
                ],
            };
        },
    }
</script>
