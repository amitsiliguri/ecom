
export function keyMapping() {

    const initializeKeyMapping = (
        list = [], map = {'label' :'label', 'id' :'id', 'children' : 'children'}
    ) => {

        let filteredList = [];

        list.forEach((item) => {
            let tempItem = {}
            let keys = Object.keys(item);
            keys.forEach((key) => {
                if (map.hasOwnProperty(key)) {
                    tempItem[map[key]] = item[key]
                } else {
                    tempItem[key] = item[key]
                }
            })
            filteredList.push(tempItem)
        })

        return filteredList
    }
    return { initializeKeyMapping }
}
