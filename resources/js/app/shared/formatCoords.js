export default function formatCoords(latitude, longitude) {
    latitude = +latitude.toFixed(6)
    longitude = +longitude.toFixed(6)
    return [latitude, longitude]
}
