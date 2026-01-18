// Marriage Certificate Dynamic Data Handler
// This script allows you to populate the certificate with data from your system

const certificateData = {
  certificateNumber: "55199",
  groom: {
    name: "KASUGA KUSAGA",
    nationalId: "CM85056141P",
    photo: "/passport-photo-male-muslim.jpg",
    guardian: "SHK IDD LUBANGA HADIMALL / MUGANDA",
  },
  bride: {
    name: "NINSIGAN DEINAH NIYOPEIRE",
    nationalId: "CM06350243",
    photo: "/passport-photo-female-muslim-hijab.jpg",
    guardian: "SHK NDIRANGWA MALUNGA / MUGANDA",
  },
  marriage: {
    residentialAddress: "MARKI MUSINSI, WAKISO DISTRICT",
    widowInfo: "N/A",
    father1: "ABDULAH KASSIM",
    father2: "NASEERI KIWANUKA",
    dowryAmount: "UGX 500,000",
    marriageDate: "22nd NOVEMBER 2023",
    specialConditions: "None",
    location: "MARKI MUSINSI, WAKISO DISTRICT",
  },
  witnesses: [
    {
      name: "ABDULAH KASSIM",
      address: "D35 NDINDO Q",
    },
    {
      name: "NASERI KIWANUKA",
      address: "NDINDO A",
    },
  ],
  imam: {
    name: "SHK ERDISA LUWANGA",
    date: "22 NOV 2023",
  },
}

// Function to populate certificate with data
function populateCertificate(data) {
  // Certificate number
  document.getElementById("certificateNumber").textContent = data.certificateNumber

  // Groom details
  document.getElementById("groomName").textContent = data.groom.name
  document.getElementById("groomID").textContent = data.groom.nationalId
  document.getElementById("groomPhoto").src = data.groom.photo
  document.getElementById("groomGuardian").textContent = data.groom.guardian
  document.getElementById("groomSignatureName").textContent = data.groom.name
  document.getElementById("groomPrintedName").textContent = data.groom.name

  // Bride details
  document.getElementById("brideName").textContent = data.bride.name
  document.getElementById("brideID").textContent = data.bride.nationalId
  document.getElementById("bridePhoto").src = data.bride.photo
  document.getElementById("brideGuardian").textContent = data.bride.guardian
  document.getElementById("brideSignatureName").textContent = data.bride.name
  document.getElementById("bridePrintedName").textContent = data.bride.name

  // Marriage details
  document.getElementById("residentialAddress").textContent = data.marriage.residentialAddress
  document.getElementById("widowInfo").textContent = data.marriage.widowInfo
  document.getElementById("father1").textContent = data.marriage.father1
  document.getElementById("father2").textContent = data.marriage.father2
  document.getElementById("dowryAmount").textContent = data.marriage.dowryAmount
  document.getElementById("marriageDate").textContent = data.marriage.marriageDate
  document.getElementById("specialConditions").textContent = data.marriage.specialConditions
  document.getElementById("marriageLocation").textContent = data.marriage.location

  // Witnesses
  document.getElementById("witness1Name").textContent = data.witnesses[0].name
  document.getElementById("witness1Address").textContent = data.witnesses[0].address
  document.getElementById("witness1SignatureName").textContent = data.witnesses[0].name

  document.getElementById("witness2Name").textContent = data.witnesses[1].name
  document.getElementById("witness2Address").textContent = data.witnesses[1].address
  document.getElementById("witness2SignatureName").textContent = data.witnesses[1].name

  // Imam and date
  document.getElementById("imamName").textContent = data.imam.name
  document.getElementById("certificateDate").textContent = data.imam.date
}

// Print function
function printCertificate() {
  window.print()
}

// Helper to read query params
function getQueryParam(name) {
  const params = new URLSearchParams(window.location.search)
  return params.get(name)
}

function fetchAndPopulate(appId) {
  fetch(`/nikkah/${appId}`)
    .then((res) => {
      if (!res.ok) throw new Error('Failed to fetch application')
      return res.json()
    })
    .then((data) => {
      const mapped = {
        certificateNumber: data.application_id || certificateData.certificateNumber,
        groom: {
          name: `${data.groom_given_name || ''} ${data.groom_surname || ''}`.trim(),
          nationalId: data.groom_nin || '',
          photo: data.groom_photo_path || certificateData.groom.photo,
          guardian: `${data.groom_father_given_name || ''} ${data.groom_father_surname || ''}`.trim() || certificateData.groom.guardian,
        },
        bride: {
          name: `${data.bride_given_name || ''} ${data.bride_surname || ''}`.trim(),
          nationalId: data.bride_nin || '',
          photo: data.bride_photo_path || certificateData.bride.photo,
          guardian: `${data.bride_father_given_name || ''} ${data.bride_father_surname || ''}`.trim() || certificateData.bride.guardian,
        },
        marriage: {
          residentialAddress:
            [data.groom_district, data.groom_parish, data.groom_village].filter(Boolean).join(', ') ||
            [data.bride_district, data.bride_parish, data.bride_village].filter(Boolean).join(', ') ||
            certificateData.marriage.residentialAddress,
          widowInfo: certificateData.marriage.widowInfo,
          father1: data.father1 || certificateData.marriage.father1,
          father2: data.father2 || certificateData.marriage.father2,
          dowryAmount: data.dowry_amount || certificateData.marriage.dowryAmount,
          marriageDate: data.marriage_date || certificateData.marriage.marriageDate,
          specialConditions: data.special_conditions || certificateData.marriage.specialConditions,
          location: data.marriage_location || certificateData.marriage.location,
        },
        witnesses: [
          { name: `${data.witness1_given_name || ''} ${data.witness1_surname || ''}`.trim(), address: data.witness1_address || '' },
          { name: `${data.witness2_given_name || ''} ${data.witness2_surname || ''}`.trim(), address: data.witness2_address || '' },
        ],
        imam: { name: data.imam_name || certificateData.imam.name, date: data.marriage_date || certificateData.imam.date },
      }

      populateCertificate(mapped)
    })
    .catch((err) => {
      console.warn('Could not load application data for certificate preview:', err)
      // fallback to sample data
      populateCertificate(certificateData)
    })
}

// Initialize: prefer session preview data, otherwise fetch app data if provided
document.addEventListener("DOMContentLoaded", () => {
  try {
    const previewJson = sessionStorage.getItem('nikkah_preview_data')
    const groomPreview = sessionStorage.getItem('nikkah_preview_groom_photo')
    const bridePreview = sessionStorage.getItem('nikkah_preview_bride_photo')

    if (previewJson) {
      const preview = JSON.parse(previewJson)
      const mapped = {
        application_id: preview.application_id || certificateData.certificateNumber,
        groom: {
          name: `${preview.groom_given_name || ''} ${preview.groom_surname || ''}`.trim(),
          nationalId: preview.groom_nin || '',
          photo: groomPreview || certificateData.groom.photo,
          guardian: `${preview.groom_father_given_name || ''} ${preview.groom_father_surname || ''}`.trim() || certificateData.groom.guardian,
        },
        bride: {
          name: `${preview.bride_given_name || ''} ${preview.bride_surname || ''}`.trim(),
          nationalId: preview.bride_nin || '',
          photo: bridePreview || certificateData.bride.photo,
          guardian: `${preview.bride_father_given_name || ''} ${preview.bride_father_surname || ''}`.trim() || certificateData.bride.guardian,
        },
        marriage: {
          residentialAddress: preview.groom_district || preview.bride_district || certificateData.marriage.residentialAddress,
          dowryAmount: preview.dowry_amount || certificateData.marriage.dowryAmount,
          marriageDate: preview.marriage_date || certificateData.marriage.marriageDate,
          specialConditions: certificateData.marriage.specialConditions,
          location: certificateData.marriage.location,
        },
        witnesses: [
          { name: preview.witness1_name || certificateData.witnesses[0].name, address: preview.witness1_address || certificateData.witnesses[0].address },
          { name: preview.witness2_name || certificateData.witnesses[1].name, address: preview.witness2_address || certificateData.witnesses[1].address },
        ],
        imam: { name: preview.imam_name || certificateData.imam.name, date: preview.marriage_date || certificateData.imam.date },
      }

      populateCertificate(mapped)

      // clear temporary preview data
      sessionStorage.removeItem('nikkah_preview_data')
      sessionStorage.removeItem('nikkah_preview_groom_photo')
      sessionStorage.removeItem('nikkah_preview_bride_photo')
      return
    }
  } catch (e) {
    // ignore and try app id
  }

  const appId = getQueryParam('app') || getQueryParam('id') || (document.getElementById('application_db_id') && document.getElementById('application_db_id').value)
  if (appId) {
    fetchAndPopulate(appId)
  } else {
    populateCertificate(certificateData)
  }
})

// Export function for integration with your system
function updateCertificateData(newData) {
  Object.assign(certificateData, newData)
  populateCertificate(certificateData)
}

// Make functions available globally
window.printCertificate = printCertificate
window.updateCertificateData = updateCertificateData
