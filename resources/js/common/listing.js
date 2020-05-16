import Vue from 'vue'

export default Vue.component('listing', {
    props: {
        api: {
            type: Function,
            required: true
        },
        columns: {
            type: Array,
            required: true
        },
        binding: {
            type: Object
        }
        // TODO: merge pagination props and data
    },
    data () {
        return {
            data: [],
            pagination: {
                showSizeChanger: true
            },
            loading: true,
            filters: [],
            sorter: {},
            keyword: ''
        }
    },
    mounted () {
        this.fetchData()
    },
    methods: {
        fetchData () {
            // pass data to api
            this.loading = true
            this.api({
                pagination: this.pagination,
                filters: this.filters,
                sorter: this.sorter,
                keyword: this.keyword
            }).then(({data}) => {
                // update current page and loading status
                const pagination = { ...this.pagination }
                pagination.total = data.total
                this.data = data.data
                this.pagination = pagination
                this.loading = false
            })
        },
        handleChange (pagination, filters, sorter) {
            const pager = { ...this.pagination }
            pager.current = pagination.current
            pager.pageSize = pagination.pageSize
            this.pagination = pager
            this.filters = filters
            this.sorter = sorter
            this.fetchData()
        },
        handleSearch (keyword) {
            this.keyword = keyword
            this.fetchData()
        },
        handleDelete (record) {
            // TODO
        }
    }
})
