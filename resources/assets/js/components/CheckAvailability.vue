<template>
    <div class="relative">
        <div class="input-group">
            <span class="input-group-addon" id="sizing-addon2"><span class="glyphicon glyphicon-barcode"></span></span>
            <input id="barcode" type="text" class="form-control" name="barcode" :autofocus="focus" v-model="barcode" style="background: none;">
        </div>

        <span class="text-success glyphicon glyphicon-ok-circle available-icon" title="This book is available" v-if="available === 2"></span>
        <span class="text-danger glyphicon glyphicon-remove-circle unavailable-icon" title="This book has been already lent" v-else-if="available === 1"></span>
        <span class="text-danger glyphicon glyphicon-ban-circle unavailable-icon" title="This book doesn't exist in out database" v-else-if="available === 0"></span>
    </div>
</template>

<script>
    export default {
        props: [
            'focus',
            'value',
        ],
        data() {
            return {
                available: 0,
                barcode: '',
            }
        },
        methods: {
            checkAvailability() {
                if (this.barcode) {
                    axios.get(`/api/books/${this.barcode}/is-available`)
                        .then(response => this.available = response.data)
                        .catch(error => console.error(error))
                } else {
                    this.available = null
                }
            },
        },
        watch: {
            barcode() {
                this.checkAvailability()
            },
        },
        mounted() {
            this.barcode = this.value
        },
    }
</script>
