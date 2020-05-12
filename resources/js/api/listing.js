export default function index ({ pagination, filters, sorter, keyword }, api) {
    const query = {}
    console.log(filters)
    if (sorter.field) {
        query.orderBy = sorter.field
        query.direction = sorter.order === 'descend' ? 'desc' : 'asc'
    }

    if (pagination.current) {
        query.page = pagination.current
    }

    if (pagination.pageSize) {
        query.perPage = pagination.pageSize
    }

    if (keyword) {
        query.keyword = keyword
    }

    return window.axios.get(api, { params: query });
}
