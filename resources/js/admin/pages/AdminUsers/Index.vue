<template>
    <div>
        <a-page-header
            style="border: 1px solid rgb(235, 237, 240); background: #fff"
            title="Admin Users"
        />

        <div class="p3">
            <a-card>
                <a-table :columns="columns">

                </a-table>
            </a-card>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Index",
        data () {
            return {
                columns: [
                    { dataIndex: 'name', key: 'name', title: 'Name' },
                    { dataIndex: 'email', key: 'email', title: 'Email'},
                    { dataIndex: 'roles', key: 'roles', title: 'Roles'},
                    { dataIndex: 'actions', key: 'actions', title: 'Actions'}
                ]
            }
        }
    }
</script>

<style scoped>

</style>
