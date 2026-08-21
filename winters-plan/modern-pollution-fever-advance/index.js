document.addEventListener("DOMContentLoaded", () => {
  const forms = [
    document.getElementById("mobileForm"),
    document.getElementById("desktopForm"),
  ];

  forms.forEach((form) => {
    if (!form) return;

    form.addEventListener("submit", async (e) => {
      e.preventDefault();

      const nameInput = form.querySelector('[name="name"]');
      const phoneInput = form.querySelector('[name="phone"]');
      const citySelect = form.querySelector('[name="city"]');

      if (!nameInput || !phoneInput || !citySelect) {
        alert("⚠️ Form elements missing or IDs incorrect.");
        return;
      }

      const name = nameInput.value.trim();
      const phone = phoneInput.value.trim();
      const city = citySelect.value.trim();

      if (!name || !phone || !city) {
        alert("⚠️ Please fill all fields before submitting.");
        return;
      }

      const formData = { name, phone, city };

      try {
        const res = await fetch("https://mdrc-landingpage-backend.onrender.com/api/book-test", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(formData),
        });

        let data;
        try {
          data = await res.json();
        } catch {
          data = { message: "Invalid JSON response" };
        }

        if (res.ok) {
          alert("✅ Thank you! Your enquiry has been submitted successfully.");
          form.reset();
        } else {
          alert("❌ Failed: " + (data.message || "Please try again."));
        }
      } catch (error) {
        console.error("Fetch Error:", error);
        alert("⚠️ Server error. Please ensure backend is running.");
      }
    });
  });
});
