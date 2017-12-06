<template>
    <div class="bg-white books-table-wrapper" style="overflow-x: scroll;">
        <table class="table" id="books-table">
            <thead>
                <tr>
                    <th @click="sortBy('title')">
                        <div>
                            <span class="heading-text">Title</span>
                            <span
                                class="icon glyphicon glyphicon-arrow-down"
                                :class="{ 'visible': this.sort === 'title', 'reversed': this.order === 'desc' }"
                            ></span>
                        </div>
                    </th>
                    <th @click="sortBy('author')">
                        <div>
                            <span class="heading-text">Author</span>
                            <span
                                class="icon glyphicon glyphicon-arrow-down"
                                :class="{ 'visible': this.sort === 'author', 'reversed': this.order === 'desc' }"
                            ></span>
                        </div>
                    </th>
                    <th @click="sortBy('publisher')">
                        <div>
                            <span class="heading-text">Publisher</span>
                            <span
                                class="icon glyphicon glyphicon-arrow-down"
                                :class="{ 'visible': this.sort === 'publisher', 'reversed': this.order === 'desc' }"
                            ></span>
                        </div>
                    </th>
                    <th @click="sortBy('barcode')">
                        <div>
                            <span class="heading-text">Barcode</span>
                            <span
                                class="icon glyphicon glyphicon-arrow-down"
                                :class="{ 'visible': this.sort === 'barcode', 'reversed': this.order === 'desc' }"
                            ></span>
                        </div>
                    </th>
                    <th @click="sortBy('release_date')" style="min-width: 130px">
                        <div>
                            <span class="heading-text">Release Date</span>
                            <span
                                class="icon glyphicon glyphicon-arrow-down"
                                :class="{ 'visible': this.sort === 'release_date', 'reversed': this.order === 'desc' }"
                            ></span>
                        </div>
                    </th>
                    <th @click="sortBy('is_available')">
                        <div>
                            <span class="heading-text">Available?</span>
                            <span
                                class="icon glyphicon glyphicon-arrow-down"
                                :class="{ 'visible': this.sort === 'is_available', 'reversed': this.order === 'desc' }"
                            ></span>
                        </div>
                    </th>
                    <th v-if="canUpdateBooks || canDeleteBooks || canLendBooks" style="min-width: 220px"></th>
                </tr>
            </thead>
            <tbody>
                <tr class="visible-on-hover" v-for="book in sortedBooks">
                    <td>{{ book.title }}</td>
                    <td>{{ book.author }}</td>
                    <td>{{ book.publisher }}</td>
                    <td>{{ book.barcode }}</td>
                    <td class="text-center">{{ book.release_date }}</td>
                    <td class="text-center"><span :class="(book.is_available === 1) ? 'text-success glyphicon glyphicon-ok' : 'text-danger glyphicon glyphicon-remove'"></span></td>
                    <td class="books-controls" v-if="canUpdateBooks || canDeleteBooks || canLendBooks">
                        <a
                            v-if="canLendBooks && book.is_available == '1'"
                            :href="`${baseUrl}/checkout/create/${book.id}`"
                            class="should-appear"
                          style="margin-right: 1rem"
                        ><span class="glyphicon glyphicon-bookmark"></span> Lend</a>
                        <form
                            v-else-if="canLendBooks && book.is_available == '0'"
                            :action="`${baseUrl}/checkout/${book.id}`"
                            method="post"
                            accept-charset="utf-8"
                        >
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" :value="csrfToken">

                            <button type="submit" class="should-appear btn btn-link inline">
                                <span class="glyphicon glyphicon-repeat"></span> Return
                            </button>
                        </form>

                        <a
                            v-if="canUpdateBooks"
                            :href="`${baseUrl}/books/${book.id}/edit`"
                            class="should-appear"
                            style="margin-right: 1rem"
                        ><span class="glyphicon glyphicon-pencil"></span> Edit</a>
                        <form
                            v-if="canDeleteBooks"
                            :action="`${baseUrl}/books/${book.id}`"
                            method="post"
                            accept-charset="utf-8"
                        >
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" :value="csrfToken">

                            <button type="submit" class="should-appear btn btn-link text-danger inline">
                                <span class="glyphicon glyphicon-trash"></span> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="text-center paginator">
            <ul class="pagination">
                <li :class="{ 'disabled': page === 1 }" @click="prev"><span>«</span></li>

                <li
                    v-for="i in pages"
                    :class="{ 'active': page === i, 'disabled': i === '...' }"
                    @click="(i !== '...') ? page = i : ''"

                ><span>{{ i }}</span></li>

                <li :class="{ 'disabled': page === lastPage() }" @click="next"><span>»</span></li>
            </ul>
        </div>
    </div>
</template>

<script>
    import appendQuery from '../appendQuery'

    export default {
        props: [
            'baseUrl',
            'books',
            'canLendBooks',
            'canUpdateBooks',
            'canDeleteBooks',
            'search',
        ],
        data() {
            return {
                sort: null,
                order: null,
                limit: 20,
                page: 1,
                pages: [],
            }
        },
        computed: {
            csrfToken() {
                return window.csrf_token
            },
            filteredBooks() {
                if (this.search) {
                    return this.books.filter(book => {
                        return book.title.toLowerCase().includes(this.search.toLowerCase())
                            || book.author.toLowerCase().includes(this.search.toLowerCase())
                            || book.publisher.toLowerCase().includes(this.search.toLowerCase())
                            || book.barcode.toLowerCase().includes(this.search.toLowerCase())
                            || book.release_date.includes(this.search.toLowerCase())
                    })
                } else {
                    return JSON.parse(JSON.stringify(this.books))
                }
            },
            sortedBooks() {
                if (this.sort === null) {
                    return JSON.parse(JSON.stringify(this.filteredBooks)).slice((this.page - 1) * this.limit, this.page * this.limit + 1)
                }

                return JSON.parse(JSON.stringify(this.filteredBooks)).sort((a, b) => {
                    let fieldA = a[this.sort]
                    let fieldB = b[this.sort]

                    if (fieldA === 1) fieldA = 'A'
                    if (fieldA === 0) fieldA = 'B'
                    if (fieldB === 1) fieldB = 'A'
                    if (fieldB === 0) fieldB = 'B'

                    String(fieldA).toLowerCase()
                    String(fieldB).toLowerCase()

                    if (this.order === 'asc')  {
                        return (fieldA < fieldB) ? -1 : 1
                    } else {
                        return (fieldA > fieldB) ? -1 : 1
                    }
                }).slice((this.page - 1) * this.limit, this.page * this.limit + 1)
            },
        },
        methods: {
            sortBy(field) {
                if (this.sort === field && this.order === 'asc') {
                    this.order = 'desc'
                } else if (this.sort === field && this.order === 'desc') {
                    this.sort = null
                    this.order = null
                } else {
                    this.sort = field
                    this.order = 'asc'
                }
            },
            prev() {
                if (this.page > 1) {
                    this.page--
                }
            },
            next() {
                if (this.page < this.lastPage()) {
                    this.page++
                }
            },
            lastPage() {
                return Math.ceil(this.filteredBooks.length / this.limit)
            },
            displayPages() {
                this.pages = []

                if (this.page > 5) {
                    this.pages.push(1)
                    this.pages.push(2)
                    this.pages.push('...')
                }
                for (let i = 0; i < this.lastPage(); i++) {
                    if (Math.abs(this.page - i) < 5) {
                        this.pages.push(i + 1)
                    }
                }
                if (this.page < this.lastPage() - 5) {
                    this.pages.push('...')
                    this.pages.push(this.lastPage() - 1)
                    this.pages.push(this.lastPage())
                }
            },
        },
        watch: {
            order() {
                history.pushState({}, 'Library', appendQuery(window.location.href, `order=${this.order}`))
            },
            sort() {
                history.pushState({}, 'Library', appendQuery(window.location.href, `sort=${this.sort}`))
            },
            page() {
                history.pushState({}, 'Library', appendQuery(window.location.href, `page=${this.page}`))

                this.displayPages()
            },
            search() {
                history.pushState({}, 'Library', appendQuery(window.location.href, `search=${this.search}`))

                this.displayPages()
            },
        },
        mounted() {
            this.page = document.head.querySelector('meta[name="page"]').content || 1
            this.order = (document.head.querySelector('meta[name="order"]').content !== 'null') ? document.head.querySelector('meta[name="order"]').content : null || null
            this.sort = (document.head.querySelector('meta[name="sort"]').content !== 'null') ? document.head.querySelector('meta[name="sort"]').content : null || null

            this.displayPages()
        },
    }
</script>
