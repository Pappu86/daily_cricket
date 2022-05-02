<template>
    <div class="row">
        <template v-if="accessToken">
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
                        <div v-if="cricketMatches && cricketMatches.length > 0">
                            <ul class="live-container">
                                <li
                                    v-for="item in cricketMatches"
                                    :key="item.match_id"
                                >
                                    <div class="live-item">
                                        <div
                                            :class="
                                                getClassName(
                                                    item.status,
                                                    'circle'
                                                )
                                            "
                                        ></div>
                                        <div
                                            :class="
                                                getClassName(
                                                    item.status,
                                                    'status'
                                                )
                                            "
                                        >
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
                                                                item.teama
                                                                    .logo_url
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
                                                                item.teamb
                                                                    .logo_url
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
                                        {{
                                            getMatchStartTime(
                                                item.date_start_ist
                                            )
                                        }}
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
        </template>
        <template v-else>
            <div class="col-md-12 not-found-container">
                <span>
                    We didn't find anything to show here. Please, set your valid
                    access token from
                </span>
                <span class="click-here"><a href="/"> here. </a></span>
            </div>
        </template>
    </div>
</template>

<script>
import moment from "moment";
import _ from "lodash";
import Loader from "./Loader.vue";

import { showLoader, hideLoader } from "../generalHelpers";

export default {
    data() {
        return {
            accessToken: !!localStorage.getItem("accessToken")
                ? localStorage.getItem("accessToken")
                : "",
            limit: 10,
            limitTarget: 70,
            startDate: prepareDateFormat(),
            endDate: "2025-01-1",
            status: 1,
            isValidAPIToken: false,
            cricketMatches: [],
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
            getClassName: function (status, type) {
                let name = "match-status",
                    statusStr = "Upcoming";

                if (status === 2) {
                    statusStr = "Completed";
                }
                if (status === 3) {
                    statusStr = "Live";
                }

                return "match-" + type + " " + "status-" + statusStr;
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
            let instance = this;
            instance.limit = value;

            if (instance.limit <= instance.limitTarget) {
                showLoader(false);
                setTimeout(() => {
                    hideLoader();
                    setCricketMatches(this);
                }, 1000);
            } else {
                // Hide loadmore button
                $("#load-more").hide();
            }
        },
    },
    mounted() {
        let instance = this;
        instance.$nextTick(() => {
            setTimeout(() => {
                setCricketMatches(instance);
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
 * @set All cricket matches data in this instance
 */
const setCricketMatches = (instance) => {
    const accessToken = instance.accessToken;
    let filters = `&date=${instance.endDate}_${instance.startDate}&paged=1&per_page=${instance.limit}`,
        apiUrl = `https://rest.entitysport.com/v2/matches?status=${instance.status}${filters}&token=${accessToken}`,
        liveApiUrl = `https://rest.entitysport.com/v2/matches?status=3${filters}&token=${accessToken}`,
        upcomingMetches = [],
        liveMatches = [];

    // API call for get live match data
    $.ajax({
        type: "GET",
        dataType: "json",
        url: liveApiUrl,
        success: function (data) {
            if (data && data.response && _.size(data.response.items)) {
                liveMatches = data.response.items;
            }

            // API call for get Upcoming match data
            $.ajax({
                type: "GET",
                dataType: "json",
                url: apiUrl,
                success: function (data) {
                    if (data && data.response && _.size(data.response.items)) {
                        upcomingMetches = data.response.items;
                    }
                    instance.cricketMatches = [
                        ...liveMatches,
                        ...upcomingMetches,
                    ];
                },
            });
        },
    });
};
</script>

<style scoped>
.click-here {
    margin-left: 5px;
}
.click-here a {
    text-decoration: none;
}

@media (max-width: 740px) {
    ul.live-container li > .live-item:nth-child(2) {
        flex-basis: 63%;
    }
    .team-details span:nth-child(1),
    .team-details span:nth-child(5) {
        flex-basis: 27%;
    }
    .country-name,
    .vs,
    .start-time {
        font-size: 1rem;
    }
}

@media (max-width: 412px) {
    ul.live-container li > .live-item:nth-child(1) {
        flex-basis: 33%;
    }
    ul.live-container li > .live-item:nth-child(2) {
        flex-basis: 48%;
    }
    .team-details span:nth-child(1),
    .team-details span:nth-child(5) {
        flex-basis: 27%;
    }
    .match-circle {
        width: 45px;
        height: 45px;
    }
    .match-status {
        height: 30px;
        line-height: 2.8;
    }
    .country-name,
    .vs,
    .start-time {
        font-size: 1rem;
    }
}
</style>
