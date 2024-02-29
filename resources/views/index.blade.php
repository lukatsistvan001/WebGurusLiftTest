<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lifts Controllers</title>
</head>

<body>
    <h1>Lifts Controllers</h1>
    <h2>Lift A position: <span id="liftAPosition">0</span></h2>
    <h2>Lift B position: <span id="liftBPosition">6</span></h2>

    <h3>Lift A controller</h3>
    <label for="liftAControl">Target floor: </label>
    <input type="number" id="liftAControl" name="liftAControl" value="0" min="0" max="6">
    <button onclick="moveLift('A')">Move</button>

    <h3>Lift B controller</h3>
    <label for="liftBControl">Target floor: </label>
    <input type="number" id="liftBControl" name="liftBControl" value="6" min="0" max="6">
    <button onclick="moveLift('B')">Move</button>

    <h3>Call nearest lift to floor</h3>
    <label for="buildingControl">Target floor: </label>
    <input type="number" id="buildingControl" name="buildingControl" min="0" max="6">
    <button onclick="callNearestLift()">Call</button>

    <script>
        const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
        // async function moveLift(liftName) {
        //     let targetFloor = document.getElementById(`lift${liftName}Control`).value;
        //     document.getElementById(`lift${liftName}Position`).innerText = targetFloor;
        // }
        function liftControl(liftName, currentFloor, targetFloor, callback) {
            const movingLift = () => {
                if (currentFloor != targetFloor) {
                    if (currentFloor <= targetFloor) {
                        currentFloor++;
                    } else if (currentFloor > targetFloor) {
                        currentFloor--;
                    }
                    document.getElementById(`lift${liftName}Position`).innerText = currentFloor;
                    setTimeout(movingLift, 1000);
                } else {
                    document.getElementById(`lift${liftName}Control`).value = targetFloor;
                    alert(`Lift ${liftName} arrived.`);
                }
            };
            callback(movingLift);
        }

        function moveLift(liftName) {
            let currentFloor = document.getElementById(`lift${liftName}Position`).innerText;
            let targetFloor = document.getElementById(`lift${liftName}Control`).value;
            fetch('/move-lift', {
                method: 'POST',
                body: JSON.stringify({
                    'liftName': liftName,
                    'targetFloor': targetFloor
                }),
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, /",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": csrfToken
                }
            }).then((response) => {
                return response.json();
            }).then((data) => {
                liftControl(liftName, currentFloor, targetFloor, movingLift => {
                    movingLift();
                });
            }).catch((error) => {
                console.log(error);
            });
        }

        async function callNearestLift() {
            const destinationFloor = document.getElementById('buildingControl').value;
            fetch('/call-nearest-lift', {
                method: 'POST',
                body: JSON.stringify({
                    'destinationFloor': destinationFloor,
                    'liftACurrentFloor': document.getElementById(`liftAPosition`).innerText,
                    'liftBCurrentFloor': document.getElementById(`liftBPosition`).innerText,
                }),
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, /",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": csrfToken
                }
            }).then((response) => {
                return response.json();
            }).then((data) => {
                liftControl(data.liftName, data.currentFloor, data.destinationFloor, movingLift => {
                    movingLift();
                })
            }).catch((error) => {
                console.log(error);
            });
        }
    </script>
</body>

</html>