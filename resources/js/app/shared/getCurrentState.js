export default async function getCurrentState(coords) {
    const apiKey = 'de7fdcfba2734932be8d31c84963114a'

    try {
        // Need a single axios instance w/o X-Requested-With
        const axiosService = require('axios')
        delete axiosService.defaults.headers.common['X-Requested-With']

        return (await axiosService.get(
                `https://api.opencagedata.com/geocode/v1/json?q=${
                    coords.join('+')
                }&key=${ apiKey }`
            )).data.results[0].components.state

    } catch (error) {
        console.log(`Could not determine what state you're in.`)
    }
}
