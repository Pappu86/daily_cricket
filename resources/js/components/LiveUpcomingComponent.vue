<template>
    <div class="row">
        <!-- Start tab-container -->
        <div class="col-md-12 tab-container">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button
                        class="nav-link active"
                        id="nav-home-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#liveUpcomingContainer"
                        type="button"
                        role="tab"
                        aria-controls="nav-home"
                        aria-selected="true"
                    >
                        Live & Upcoming
                    </button>
                    <button
                        class="nav-link"
                        id="nav-profile-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#result"
                        type="button"
                        role="tab"
                        aria-controls="nav-profile"
                        aria-selected="false"
                    >
                        Result
                    </button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div
                    class="tab-pane fade show active"
                    id="liveUpcomingContainer"
                    role="tabpanel"
                    aria-labelledby="nav-home-tab"
                >
                    <div v-if="allMatches">
                        <ul class="live-container">
                            <li v-for="item in allMatches" :key="item.match_id">
                                <div class="live-item">
                                    <div class="match-circle"></div>
                                    <div class="match-status">
                                        {{ getStatusStr(item.status) }}
                                    </div>
                                    <small class="match">
                                        {{ item.subtitle }}
                                    </small>
                                </div>
                                <div class="live-item">
                                    <div class="team-details">
                                        <span class="country-name">
                                            {{ item.teama.name }}
                                        </span>
                                        <span>
                                            <p class="country-logo">
                                                <img
                                                    :src="
                                                        countryLogoUrl(
                                                            item.teama.logo_url
                                                        )
                                                    "
                                                    itemprop="image"
                                                />
                                            </p>
                                        </span>
                                        <span class="vs">VS</span>
                                        <span>
                                            <p class="country-logo">
                                                <img
                                                    :src="
                                                        countryLogoUrl(
                                                            item.teamb.logo_url
                                                        )
                                                    "
                                                    itemprop="image"
                                                />
                                            </p>
                                        </span>
                                        <span class="country-name">
                                            {{ item.teamb.name }}
                                        </span>
                                    </div>
                                    <div class="venu-name">
                                        {{ item.venue.name }},
                                        {{ item.venue.location }}
                                        {{
                                            getLocalTime(
                                                item.status_note,
                                                item.timestamp_start
                                            )
                                        }}
                                    </div>
                                </div>
                                <div class="live-item start-time">
                                    {{ getMatchStartTime(item.date_start_ist) }}
                                </div>
                            </li>
                        </ul>
                        <!-- Start Loader -->
                        <div class="row">
                            <loader
                                @hendleLoadMore="hendleLoadMore"
                                :dataLimit="limit"
                            ></loader>
                        </div>
                        <!-- End Loader -->
                    </div>
                    <div v-else>
                        <div class="not-foun-msg">
                            We didn't find anything to show here.
                        </div>
                    </div>
                </div>
                <div
                    class="tab-pane fade"
                    id="result"
                    role="tabpanel"
                    aria-labelledby="nav-profile-tab"
                >
                    <div class="not-foun-msg">
                        We didn't find anything to show here.
                    </div>
                </div>
            </div>
        </div>
        <!-- End tab-container -->
    </div>
</template>

<script>
import moment from "moment";
import Loader from "./Loader.vue";

export default {
    data(props) {
        return {
            accessToken: "",
            limit: 10,
            startDate: prepareDateFormat(),
            endDate: "2025-01-1",
            status: 1,
            isValidAPIToken: false,
            allMatches: [],
            getStatusStr: function (status) {
                let statusStr = "Upcoming";
                if (status === 2) {
                    statusStr = "Completed";
                }
                if (status === 3) {
                    statusStr = "Live";
                }
                return statusStr;
            },
            getLocalTime: function (time, timestampStart) {
                return !!time
                    ? time.slice(9)
                    : new Date(timestampStart).toLocaleTimeString() +
                          " local time";
            },
            countryLogoUrl: function (logoUrl) {
                return !!logoUrl
                    ? logoUrl
                    : "https://cricket.entitysport.com/assets/uploads/2020/07/team-120x120.png";
            },
            getMatchStartTime: function (timeStr) {
                return moment(timeStr).format("h:mm a");
            },
        };
    },
    components: {
        loader: Loader,
    },
    methods: {
        hendleLoadMore: function (event, value) {
            showLoader(false);
            let instance = this;
            instance.limit = value;

            setTimeout(() => {
                hideLoader();
                instance.allMatches = []; //getAllMatches(this);
            }, 1000);
        },
    },
    mounted() {
        let instance = this;
        instance.$nextTick(() => {
            instance.allMatches = [];
            setTimeout(() => {
                //getMatches(instance);
                instance.allMatches = getAllMatches(instance);
                hideLoader();
            }, 1000);
        });
    },
};

/**
 * Prepare date formate YYYY-MM-DD
 *
 * @param string
 * @return date string
 */

const prepareDateFormat = (dateStr = "") => {
    let d = dateStr ? dateStr : new Date(),
        isoDateStr = !!d && d.toISOString(),
        dateWithoutTimezone = !!isoDateStr && isoDateStr.split("T")[0];

    return dateWithoutTimezone;
};

/**
 * Get all match info
 *
 * @param vue instance
 * @return All matches info
 */
const getAllMatches = (instance) => {
    const accessToken = "9e272eadc7907624ee8bb8d4b0eca1f5";
    let filters = `&date=${instance.endDate}_${instance.startDate}&paged=1&per_page=${instance.limit}`,
        apiUrl = `https://rest.entitysport.com/v2/matches?status=${instance.status}${filters}&token=${accessToken}`;

    console.log("upcomingUrl", apiUrl);
    // $.ajax({
    //     url: apiUrl,
    //     jsonp: "callback",
    //     dataType: "jsonp",
    //     // data: {
    //     //     status: "1",
    //     //     token: accessToken,
    //     // },
    //     success: function (response) {
    //         console.log(response);
    //     },
    // });

    // axios
    //     .get(apiUrl)
    //     .then((res) => {
    //         console.log("items: ", res);
    //     })
    //     .catch((error) => {
    //         console.log("Pappu");
    //         instance.isValidAccToken = false;
    //         instance.matches = [];
    //         console.log(error);
    //     });

    return [
        {
            match_id: 54430,
            title: "Guernsey vs Norway",
            short_title: "GUE vs Norwy",
            subtitle: "Match 1",
            format: 3,
            format_str: "T20I",
            status: 1,
            status_str: "Scheduled",
            status_note: "",
            verified: "false",
            pre_squad: "true",
            odds_available: "false",
            game_state: 0,
            game_state_str: "Default",
            domestic: "0",
            competition: {
                cid: 124435,
                title: "Spain Triangular T20I Series",
                abbr: "STT20S",
                type: "series",
                category: "international",
                match_format: "t20i",
                status: "live",
                season: "2022",
                datestart: "2022-04-29",
                dateend: "2022-05-01",
                country: "int",
                total_matches: "6",
                total_rounds: "1",
                total_teams: "3",
            },
            teama: {
                team_id: 10528,
                name: "Guernsey",
                short_name: "GUE",
                logo_url:
                    "https://images.entitysport.com/assets/uploads/2020/12/Guernsey.png",
            },
            teamb: {
                team_id: 19682,
                name: "Norway",
                short_name: "Norwy",
                logo_url:
                    "https://images.entitysport.com/assets/uploads/2020/12/Norwaypng.png",
            },
            date_start: "2022-04-29 13:00:00",
            date_end: "2022-04-29 23:00:00",
            timestamp_start: 1651237200,
            timestamp_end: 1651273200,
            date_start_ist: "2022-04-29 18:30:00",
            date_end_ist: "2022-04-30 04:30:00",
            venue: {
                venue_id: "1207080",
                name: "Desert Springs Cricket Ground, Almeria",
                location: "Almeria",
                timezone: "-12",
            },
            umpires: "",
            referee: "",
            equation: "",
            live: "",
            result: "",
            result_type: "",
            win_margin: "",
            winning_team_id: 0,
            commentary: 1,
            wagon: 0,
            latest_inning_number: 0,
            presquad_time: "2022-04-28 12:47:03",
            verify_time: "",
            toss: {
                winner: 0,
                decision: 0,
            },
        },
        {
            match_id: 53368,
            title: "Punjab Kings vs Lucknow Super Giants",
            short_title: "PBKS vs LSG",
            subtitle: "Match 42",
            format: 6,
            format_str: "T20",
            status: 1,
            status_str: "Scheduled",
            status_note: "",
            verified: "false",
            pre_squad: "true",
            odds_available: "false",
            game_state: 0,
            game_state_str: "Default",
            domestic: "1",
            competition: {
                cid: 123213,
                title: "Indian Premier League",
                abbr: "IPL",
                type: "tournament",
                category: "domestic",
                match_format: "t20",
                status: "live",
                season: "2022",
                datestart: "2022-03-26",
                dateend: "2022-05-29",
                country: "in",
                total_matches: "70",
                total_rounds: "1",
                total_teams: "10",
            },
            teama: {
                team_id: 627,
                name: "Punjab Kings",
                short_name: "PBKS",
                logo_url:
                    "https://images.entitysport.com/assets/uploads/2021/03/PK-Logo.png",
            },
            teamb: {
                team_id: 123214,
                name: "Lucknow Super Giants",
                short_name: "LSG",
                logo_url:
                    "https://images.entitysport.com/assets/uploads/2022/03/Lucknow-Super-Giantslogo.png",
            },
            date_start: "2022-04-29 14:00:00",
            date_end: "2022-04-30 00:00:00",
            timestamp_start: 1651240800,
            timestamp_end: 1651276800,
            date_start_ist: "2022-04-29 19:30:00",
            date_end_ist: "2022-04-30 05:30:00",
            venue: {
                venue_id: "24",
                name: "Maharashtra Cricket Association Stadium, Pune",
                location: "Pune",
                timezone: "-12",
            },
            umpires: "",
            referee: "",
            equation: "",
            live: "",
            result: "",
            result_type: "",
            win_margin: "",
            winning_team_id: 0,
            commentary: 1,
            wagon: 1,
            latest_inning_number: 0,
            presquad_time: "2022-04-27 09:29:13",
            verify_time: "",
            toss: {
                winner: 0,
                decision: 0,
            },
        },
        {
            match_id: 54446,
            title: "United Arab Emirates Women vs Hong Kong Women",
            short_title: "UAE-W vs HKG-W",
            subtitle: "3rd T20I",
            format: 8,
            format_str: "Woman T20",
            status: 1,
            status_str: "Scheduled",
            status_note: "",
            verified: "false",
            pre_squad: "true",
            odds_available: "false",
            game_state: 0,
            game_state_str: "Default",
            domestic: "0",
            competition: {
                cid: 124441,
                title: "Hong Kong Women tour of UAE",
                abbr: "HKWTOUSE",
                type: "tour",
                category: "women",
                match_format: "woment20",
                status: "live",
                season: "2022",
                datestart: "2022-04-27",
                dateend: "2022-04-30",
                country: "int",
                total_matches: "4",
                total_rounds: "1",
                total_teams: "2",
            },
            teama: {
                team_id: 111324,
                name: "United Arab Emirates Women",
                short_name: "UAE-W",
                logo_url:
                    "https://images.entitysport.com/assets/uploads/2020/12/United_Arab_Emirates.png",
            },
            teamb: {
                team_id: 26771,
                name: "Hong Kong Women",
                short_name: "HKG-W",
                logo_url:
                    "https://images.entitysport.com/assets/uploads/2020/12/Hong_Kong.png",
            },
            date_start: "2022-04-29 15:10:00",
            date_end: "2022-04-30 01:10:00",
            timestamp_start: 1651245000,
            timestamp_end: 1651281000,
            date_start_ist: "2022-04-29 20:40:00",
            date_end_ist: "2022-04-30 06:40:00",
            venue: {
                venue_id: "1213346",
                name: "Malek Cricket Stadium",
                location: "Abu Dhabi",
                timezone: "-12",
            },
            umpires: "",
            referee: "",
            equation: "",
            live: "",
            result: "",
            result_type: "",
            win_margin: "",
            winning_team_id: 0,
            commentary: 1,
            wagon: 0,
            latest_inning_number: 0,
            presquad_time: "2022-04-28 21:05:58",
            verify_time: "",
            toss: {
                winner: 0,
                decision: 0,
            },
        },
        {
            match_id: 54450,
            title: "Surrey Risers vs United Stars",
            short_title: "SRI vs UNS",
            subtitle: "Match 21",
            format: 17,
            format_str: "T10",
            status: 1,
            status_str: "Scheduled",
            status_note: "",
            verified: "false",
            pre_squad: "true",
            odds_available: "false",
            game_state: 0,
            game_state_str: "Default",
            domestic: "1",
            competition: {
                cid: 124334,
                title: "Dream11 Jamaica T10",
                abbr: "JamaicaT10",
                type: "tournament",
                category: "domestic",
                match_format: "t10",
                status: "live",
                season: "2022",
                datestart: "2022-04-19",
                dateend: "2022-05-05",
                country: "int",
                total_matches: "25",
                total_rounds: "1",
                total_teams: "6",
            },
            teama: {
                team_id: 124338,
                name: "Surrey Risers",
                short_name: "SRI",
                logo_url:
                    "https://images.entitysport.com/assets/uploads/2022/04/SRI-CR2@2x.png",
            },
            teamb: {
                team_id: 124341,
                name: "United Stars",
                short_name: "UNS",
                logo_url:
                    "https://images.entitysport.com/assets/uploads/2022/04/UNS-CR1@2x.png",
            },
            date_start: "2022-04-29 15:45:00",
            date_end: "2022-04-30 01:45:00",
            timestamp_start: 1651247100,
            timestamp_end: 1651283100,
            date_start_ist: "2022-04-29 21:15:00",
            date_end_ist: "2022-04-30 07:15:00",
            venue: {
                venue_id: "84",
                name: "Sabina Park, Kingston, Jamaica",
                location: "Kingston",
                timezone: "-12",
            },
            umpires: "",
            referee: "",
            equation: "",
            live: "",
            result: "",
            result_type: "",
            win_margin: "",
            winning_team_id: 0,
            commentary: 1,
            wagon: 0,
            latest_inning_number: 0,
            presquad_time: "2022-04-27 22:12:10",
            verify_time: "",
            toss: {
                winner: 0,
                decision: 0,
            },
        },
        {
            match_id: 54471,
            title: "Kabul Zalmi Live Star vs Rehan Khan Events",
            short_title: " KZLS vs RKE",
            subtitle: "Pre Quarter-final 1",
            format: 17,
            format_str: "T10",
            status: 1,
            status_str: "Scheduled",
            status_note: "",
            verified: "false",
            pre_squad: "true",
            odds_available: "false",
            game_state: 0,
            game_state_str: "Default",
            domestic: "1",
            competition: {
                cid: 124357,
                title: "Sharjah Ramadan T10 League",
                abbr: "SRT10",
                type: "tournament",
                category: "domestic",
                match_format: "t10",
                status: "live",
                season: "2022",
                datestart: "2022-04-20",
                dateend: "2022-05-10",
                country: "ae",
                total_matches: "37",
                total_rounds: "1",
                total_teams: "19",
            },
            teama: {
                team_id: 123103,
                name: "Kabul Zalmi Live Star",
                short_name: " KZLS",
                logo_url:
                    "https://images.entitysport.com/assets/uploads/2022/02/Kabul-Zalmi-Live-Star.png",
            },
            teamb: {
                team_id: 123803,
                name: "Rehan Khan Events",
                short_name: "RKE",
                logo_url:
                    "https://images.entitysport.com/assets/uploads/2022/03/RKE-CR1@2x.png",
            },
            date_start: "2022-04-29 16:00:00",
            date_end: "2022-04-30 02:00:00",
            timestamp_start: 1651248000,
            timestamp_end: 1651284000,
            date_start_ist: "2022-04-29 21:30:00",
            date_end_ist: "2022-04-30 07:30:00",
            venue: {
                venue_id: "98",
                name: "Sharjah Cricket Stadium",
                location: "Sharjah",
                timezone: "-12",
            },
            umpires: "",
            referee: "",
            equation: "",
            live: "",
            result: "",
            result_type: "",
            win_margin: "",
            winning_team_id: 0,
            commentary: 1,
            wagon: 0,
            latest_inning_number: 0,
            presquad_time: "2022-04-29 05:00:28",
            verify_time: "",
            toss: {
                winner: 0,
                decision: 0,
            },
        },
    ];

    // axios
    //     .get(apiUrl)
    //     .then((res) => {
    //         console.log("items: ", res);
    //     })
    //     .catch((error) => {
    //         instance.isValidAccToken = false;
    //         instance.matches = [];
    //         console.log(error);
    //     });
};

/**
 * Show page loader
 * @param boolean true/false
 * @result page loader show
 */

const showLoader = (isOverlay = true) => {
    if (isOverlay) {
        $("#overlayer").show();
    }
    $(".loader").show();
};

/**
 * Hide page loader
 * @param boolean true/false
 * @result page loader hode
 */

const hideLoader = (isOverlay = true) => {
    if (isOverlay) {
        $("#overlayer").hide();
    }
    $(".loader").hide();
};
</script>
