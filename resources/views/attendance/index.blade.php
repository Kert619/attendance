<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="icon" href="logo-1.svg" type="image/icon type" />
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Attendance Tracker - NOLITC</title>

  <link rel="stylesheet" href="/styles.css" />
  <link rel="shortcut icon" href="{{ asset('icon.ico') }}" type="image/x-icon">

  <!-- bootstrap -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous" />

  <style>
    * {
      padding: 0;
      margin: 0;
      box-sizing: border-box;
    }

    body {
      height: 100vh;
      width: 100vw;
    }

    .container {
      height: 80%;
      width: 80%;
    }

    .row {
      height: 100%;
    }

    .landong {
      box-shadow: -1px 0px 3px rgba(0, 0, 0, 0.2);
    }

    .left1 .right1 {
      width: 100%;
      height: 100%;
    }

    .right1 {
      background-color: #99cc99;
    }

    .ngalan {
      -webkit-text-stroke: 2px rgba(255, 255, 255, 0.2);
    }

    .curso {
      -webkit-text-stroke: 0.2px rgba(0, 0, 0, 0.2);
    }

    h1 {
      -webkit-text-stroke: 1px black;
    }

    .box1 {
      position: relative;
    }

    .box1::before {
      content: "";
      position: absolute;
      top: 7px;
      left: -15px;
      width: 10px;
      height: 10px;
      background-color: green;
    }

    .box2 {
      position: relative;
    }

    .box2::before {
      content: "";
      position: absolute;
      top: 7px;
      left: -15px;
      width: 10px;
      height: 10px;
      background-color: blue;
    }

    .box3 {
      position: relative;
    }

    .box3::before {
      content: "";
      position: absolute;
      top: 7px;
      left: -15px;
      width: 10px;
      height: 10px;
      background-color: red;
    }
  </style>
</head>

<body class="d-flex justify-content-center align-items-center">
  <div class="container rounded mt-5">
    <div class="row landong rounded">
      <div class="col-md-6">
        <div class="left1 d-flex flex-column justify-content-center align-items-center">
          <div class="background" style="width: 17vw; min-width: 100px">
            <img src="{{ asset('logo.png') }}" alt="NOLITC LOGO" class="mt-5 mb-2 img-fluid" />
          </div>
          <div class="clocking1 d-flex flex-column align-items-center">
            <div class="boxtimer text-success mt-5 mb-5">
              <h1 class="timer1 display-1 fw-bold" id="current-time"></h1>
            </div>
            <div class="boxdate mt-5">
              <h1 class="timer1 fs-1 fw-bold" id="current-date"></h1>
            </div>
          </div>
        </div>
      </div>
      <!--  -->
      <div class="col-md-6 right1 border rounded-end">
        <div class="profile d-flex justify-content-center mt-5">
          @if(isset($student))
          <div style="width: 15vw; height:15vw;  min-width: 100px; min-height: 100px;">
            @if($student->image)
            <img src="data:image/jpeg;base64,{{ $student->image }}" alt="Profile Picture" class="w-100 h-100 object-fit-cover" />
            @else
            <img src="{{ asset('no-image.png') }}" alt="Profile Picture" class="w-100 h-100 object-fit-cover" />
            @endif
          </div>
          @else
          <div style="width: 15vw; height:15vw;  min-width: 100px; min-height: 100px;">
            <img src="{{asset('user.png')}}" alt="Profile Picture" class="w-100 h-100 object-fit-cover" />
          </div>
          @endif
        </div>

        <form action="{{ route('attendance.scan') }}" method="POST">
          <div class="student1 border-bottom mt-4">
            @csrf
            <p class="text-center">
              <span class="fw-bold ngalan fs-2 d-flex flex-column">
                @if(isset($student))
                {{ $student->fullname }}
                @endif
              </span>

              <span class="fs-3 text-white fw-normal curso"></span>
            </p>
          </div>
          <!-- scanner -->
          <div class="scanner-input mt-3">
            <input type="text" class="form-control p-1 fs-3 shadow-none rounded-0" name="qr_code" placeholder="Scan your QR Code here" autofocus autocomplete="off" />
          </div>
        </form>

        <!-- Status -->
        <div class="status1 mt-5">
          @if(isset($status) && isset($timeInStatus))
          <p class="fs-5 text-center text-light py-2 px-3 mb-5 {{ $timeInStatus == 'On-Time' ? 'bg-success' : ($timeInStatus == 'Late' ? 'bg-primary' : 'bg-danger') }}">
            {{ $status }}
          </p>
          @elseif(isset($status) && !isset($timeInStatus))
          <p class="fs-5 text-center text-light py-2 px-3 mb-5 bg-danger">
            {{ $status }}
          </p>
          @endif
        </div>
        <!-- legends -->
        <p class="fw-bold">Legends:</p>
        <div class="col ms-5 gap-5">
          <span class="box1 me-4">On-Time</span>
          <span class="box2 me-4">Late</span>
          <span class="box3 me-4">Absent</span>
        </div>
      </div>
      <!--  -->
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // JavaScript code to display and continuously update current date and time
      const currentDateElement = document.getElementById("current-date");
      const currentTimeElement = document.getElementById("current-time");

      function getCurrentTime() {
        var currentTime = new Date();

        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        var seconds = currentTime.getSeconds();
        var meridiem = "AM";

        // Convert to 12-hour format
        if (hours > 12) {
          hours = hours - 12;
          meridiem = "PM";
        }

        // Pad single digits with leading zeros
        hours = addLeadingZero(hours);
        minutes = addLeadingZero(minutes);
        seconds = addLeadingZero(seconds);

        // Construct the formatted time string
        var formattedTime =
          hours + ":" + minutes + ":" + seconds + " " + meridiem;

        return formattedTime;
      }

      function addLeadingZero(number) {
        return number < 10 ? "0" + number : number;
      }

      function getCurrentDate() {
        var months = [
          "January",
          "February",
          "March",
          "April",
          "May",
          "June",
          "July",
          "August",
          "September",
          "October",
          "November",
          "December",
        ];

        var currentDate = new Date();
        var month = months[currentDate.getMonth()];
        var day = currentDate.getDate();
        var year = currentDate.getFullYear();

        // Construct the formatted date string
        var formattedDate = month + " " + day + ", " + year;

        return formattedDate;
      }

      function displayClock() {
        var time = getCurrentTime();
        document.querySelector("#current-time").textContent = time;
        var date = getCurrentDate();
        document.querySelector("#current-date").textContent = date;
      }

      // Initial update of the clock
      // getCurrentTime();

      // Update the clock every second
      setInterval(displayClock, 1000);
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>