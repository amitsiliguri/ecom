import {reactive} from "vue";

export function keyMapping() {

    const initializeKeyMapping = (
        list = [], map = {'label' :'label', 'id' :'id', 'children' : 'children'}
    ) => {
        return  mapKeys([], list, map)
    }

    const mapKeys = (filteredList, list, map) => {
        list.forEach((item) => {
            let tempItem = {}
            tempItem.id = mapping(item, 'id', map)
            tempItem.label = mapping(item, 'label', map)
            if (item.hasOwnProperty(map.children)) {
                tempItem.children = mapKeys([], item.children, map)
            }
            filteredList.push(tempItem)
        })
        return filteredList
    }

    const mapping = (item, key, map) => {
        return (item.hasOwnProperty(key)) ? item[key] : item[map[key]]
    }

    return { initializeKeyMapping }
}
