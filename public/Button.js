// my-component.js
export default {
    data() {
        return { count: 0 }
    },
    template: `<div @click="count++;">count is {{ count }}</div>`
}
