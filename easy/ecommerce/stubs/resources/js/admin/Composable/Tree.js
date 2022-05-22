export function Tree() {

    const nest = (items, id = 0, link = 'parent_id') =>
        items.filter(item => item[link] === id).map(item => ({ ...item, children: nest(items, item.id) }));

    return { nest }
}
