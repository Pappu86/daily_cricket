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
                <div id="liveUpcomingContainer" class="tab-pane active">
                    <ul class="live-container">
                        <li>
                            <div class="live-item">A</div>
                            <div class="live-item">B</div>
                            <div class="live-item">C</div>
                            <div class="live-item">D</div>
                            <div class="live-item">E</div>
                        </li>
                    </ul>
                </div>
                <div id="result" class="tab-pane">
                    <h3>Result</h3>
                    <p>Some content in result.</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        console.log("Component mounted.");
    },
};
</script>
