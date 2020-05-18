import index from "../listing";

export default {
    index (paramBag) {
        return index(paramBag, '/audits', (query) => {
            if (paramBag.range) {
                query.from = paramBag.range.from.format()
                query.to = paramBag.range.to.format()
            }
        })
    }
}
