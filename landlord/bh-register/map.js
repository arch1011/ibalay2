
    let map;
    let pushpin;

    function GetMap() {
        try {
            // Initialize the map with a default center
            const initialLocation = new Microsoft.Maps.Location(11.1090, 125.0160); // Leyte, Philippines
            map = new Microsoft.Maps.Map(document.getElementById("bingMap"), {
                center: initialLocation,
                zoom: 12, // Adjust as needed
            });

            // Add a click event listener to place a pushpin and capture coordinates
            Microsoft.Maps.Events.addHandler(map, 'click', function (event) {
                if (event.location) {
                    placePushpin(event.location); // Place a pushpin
                    setCoordinates(event.location); // Update longitude and latitude fields
                }
            });

        } catch (error) {
            console.error("Error initializing Bing Maps:", error);
        }
    }

    // Function to place a pushpin on the map
    function placePushpin(location) {
        if (pushpin) {
            pushpin.setLocation(location); // Update existing pushpin location
        } else {
            pushpin = new Microsoft.Maps.Pushpin(location); // Create a new pushpin
            map.entities.push(pushpin); // Add it to the map
        }
    }

    // Function to update longitude and latitude fields
    function setCoordinates(location) {
        const latitude = location.latitude;
        const longitude = location.longitude;

        // Update the coordinates in the form fields
        document.getElementById("Latitude").value = latitude;
        document.getElementById("Longitude").value = longitude;
    }
