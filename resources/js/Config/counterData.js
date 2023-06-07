/**
 * Contains the base data for counter in about us page.
 *
 * @type {{
 * counters: [
 *      {icon: string[], title: string, target: number},
 *      {icon: string[], title: string, target: number},
 *      {icon: string[], title: string, target: number},
 *      {icon: string[], title: string, target: number}],
 * values: [{value: number},{value: number},{value: number},{value: number}]
 * }}
 */
const counterData = {
    counters: [
        {
            icon: ["fas", "users"],
            title: "Satisfied customers",
            target: 150000
        },
        {
            icon: ["fas", "plane"],
            title: "Flights",
            target: 5500
        },
        {
            icon: ["fas", "map-location-dot"],
            title: "Routes",
            target: 2000
        },
        {
            icon: ["fas", "handshake"],
            title: "Partners",
            target: 600
        }
    ],
    values: [{ value: 0 }, { value: 0 }, { value: 0 }, { value: 0 }],
};

export default counterData;
