
document.addEventListener("DOMContentLoaded", function() {
    const modal = document.getElementById("roomDetailsModal");

    modal.addEventListener("show.bs.modal", function(event) {
        const button = event.relatedTarget;
        const roomDetails = JSON.parse(button.getAttribute("data-room-details"));

        const roomNumber = roomDetails.room_number;
        const landlordId = roomDetails.landlord_id;

        const photo1 = `/iBalay/uploads/roomphotos/room${roomNumber}_landlord${landlordId}/${roomDetails.room_photo1}`;
        const photo2 = `/iBalay/uploads/roomphotos/room${roomNumber}_landlord${landlordId}/${roomDetails.room_photo2}`;

        const carousel = `
            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="${photo1}" style='width:50px; height:200px;' class="d-block w-100" alt="Room Photo 1">
                    </div>
                    <div class="carousel-item">
                        <img src="${photo2}" style='width:50px; height:200px;' class="d-block w-100" alt="Room Photo 2">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

            <hr>
        `;

        

        const roomInfo = `
            <h6>Room Number:  ${roomNumber}</h6>
            <p>Description: ${roomDetails.description}</p>
            <p>Room Capacity: ${roomDetails.capacity}</p>
            <p>Room Price: ₱ ${roomDetails.room_price}</p>
        `;

        document.getElementById("roomDetailsContent").innerHTML = carousel + roomInfo;
    });

    new simpleDatatables.DataTable(".datatable");
});
