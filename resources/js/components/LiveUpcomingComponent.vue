<template>
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#liveUpcomingContainer">
                        Live & Upcoming
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#result">Result</a>
                </li>
            </ul>
            <div class="tab-content">
                <!-- Start live and upcoming tab container -->
                <div id="liveUpcomingContainer" class="tab-pane active">
                    <ul class="live-container">
                        <li>
                            <div class="live-item">
                                <div class="match-circle"></div>
                                <div class="match-status">Upcoming</div>
                                <small class="match">1st Quater final</small>
                            </div>
                            <div class="live-item">
                                C.K Pithawala Cricket Ground, Bhimpore, Surat 29
                                Apr, 22 Local Time
                            </div>
                            <div class="live-item">
                                <span class="country-logo">
                                    <img
                                        src="https://images.entitysport.com/assets/uploads/2020/12/Guernsey.png"
                                        itemprop="image"
                                    />
                                </span>
                                <span class="country-logo">
                                    <img
                                        src="https://images.entitysport.com/assets/uploads/2020/12/Guernsey.png"
                                        itemprop="image"
                                    />
                                </span>
                            </div>
                            <div class="live-item">
                                <span class="country-name">
                                    United Arab Emirates Women
                                </span>
                                <span class="vs">VS</span>
                                <span class="country-name">
                                    Hong Kong Women
                                </span>
                            </div>
                            <div class="live-item">9:10 PM</div>
                        </li>
                        <li>
                            <div class="live-item">
                                <div class="match-circle"></div>
                                <div class="match-status">Upcoming</div>
                                <small class="match">1st Quater final</small>
                            </div>
                            <div class="live-item">
                                C.K Pithawala Cricket Ground, Bhimpore, Surat 29
                                Apr, 22 Local Time
                            </div>
                            <div class="live-item">
                                <span class="country-logo">
                                    <img
                                        src="https://images.entitysport.com/assets/uploads/2020/12/Guernsey.png"
                                        itemprop="image"
                                    />
                                </span>
                                <span class="country-logo">
                                    <img
                                        src="https://images.entitysport.com/assets/uploads/2020/12/Guernsey.png"
                                        itemprop="image"
                                    />
                                </span>
                            </div>
                            <div class="live-item">
                                <span class="country-name">
                                    United Arab Emirates Women
                                </span>
                                <span class="vs">VS</span>
                                <span class="country-name">
                                    Hong Kong Women
                                </span>
                            </div>
                            <div class="live-item">9:10 PM</div>
                        </li>
                        <li>
                            <div class="live-item">
                                <div class="match-circle"></div>
                                <div class="match-status">Upcoming</div>
                                <small class="match">1st Quater final</small>
                            </div>
                            <div class="live-item">
                                C.K Pithawala Cricket Ground, Bhimpore, Surat 29
                                Apr, 22 Local Time
                            </div>
                            <div class="live-item">
                                <span class="country-logo">
                                    <img
                                        src="https://images.entitysport.com/assets/uploads/2020/12/Guernsey.png"
                                        itemprop="image"
                                    />
                                </span>
                                <span class="country-logo">
                                    <img
                                        src="https://images.entitysport.com/assets/uploads/2020/12/Guernsey.png"
                                        itemprop="image"
                                    />
                                </span>
                            </div>
                            <div class="live-item">
                                <span class="country-name">
                                    United Arab Emirates Women
                                </span>
                                <span class="vs">VS</span>
                                <span class="country-name">
                                    Hong Kong Women
                                </span>
                            </div>
                            <div class="live-item">9:10 PM</div>
                        </li>
                    </ul>
                </div>
                <!-- End live and upcoming tab container -->
                <div id="result" class="tab-pane">
                    <h3>Result</h3>
                    <p>Some content in result.</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            accessToken: "",
            limit: 10,
            startDate: prepareDateFormat(),
            endDate: "2025-01-1",
            status: 1,
            isValidAPIToken: false,
        };
    },
    mounted() {
        console.log("Live Component mounted.");
        let instance = this;
        instance.$nextTick(() => {
            getAllMatches(instance);
            // setInterval(() => {
            //     getMatches(instance);
            // }, 10000);
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

    console.log("dateWithoutTimezone: ", dateWithoutTimezone);

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

    axios
        .get(url)
        .then((res) => {
            let { items } = !!res.data && res.data.response;
            console.log("items: ", items);
        })
        .catch((error) => {
            instance.isValidAccToken = false;
            instance.matches = [];
            console.log(error);
        });
};
</script>
