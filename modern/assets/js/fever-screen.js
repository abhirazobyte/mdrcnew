(() => {
    'use strict'
    
    const API_URL = ''; // EXTERNAL API REMOVED: LeadSquared
    const ACCESS_KEY = '';
    const SECRET_KEY = '';
    const COMPANY_ID = '';
    
    function generateUUID() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            const r = Math.random() * 16 | 0;
            const v = c === 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    }

    function preparePayload(formData) {
        return JSON.stringify([
            {
                "Attribute": "FirstName",
                "Value": formData.fullName
            },
            {
                "Attribute": "LastName",
                "Value": ""
            },
            {
                "Attribute": "EmailAddress",
                "Value": ""
            },
            {
                "Attribute": "mx_City",
                "Value": formData.city
            },
            {
                "Attribute": "Phone",
                "Value": formData.mobile
            },
            {
                "Attribute": "ProspectID",
                "Value": generateUUID()
            },
            {
                "Attribute": "SearchBy",
                "Value": "Phone"
            },
            {
                "Attribute": "RelatedCompanyId",
                "Value": COMPANY_ID
            },
            {
                "Attribute": "RelatedCompanyId",
                "Value": COMPANY_ID
            },
            {
                "Attribute": "Source",
                "Value": "fever-screen"
            }
        ]);
    }

    async function submitToLeadSquared(payload) {
        throw new Error('External integration disabled on staging.');
        
        try {
            console.log('Sending payload:', JSON.parse(payload));
            
            const response = { ok: true, json: async () => ({ Status: "Success", Message: {} }) }; /* EXTERNAL API REMOVED: LeadSquared */ void ({
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: payload
            });
            
            const data = await response.json();
            console.log('API Response:', data);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            return data;
        } catch (error) {
            console.error('Error submitting to LeadSquared:', error);
            throw error;
        }
    }

    const forms = document.querySelectorAll('.needs-validation');
    
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', async event => {
            event.preventDefault();
            event.stopPropagation();
            
            if (form.checkValidity()) {
                try {
                    const formData = {
                        fullName: form.querySelector('input[placeholder="*Full Name"]').value,
                        mobile: form.querySelector('input[placeholder="*Mobile Number"]').value,
                        city: form.querySelector('#cityName').value
                    };
                    
                    console.log('Form Data:', formData);
                    
                    const submitButton = form.querySelector('.book-btn');
                    const originalText = submitButton.textContent;
                    submitButton.textContent = 'Processing...';
                    submitButton.disabled = true;
                    
                    const payload = preparePayload(formData);
                    const response = await submitToLeadSquared(payload);
                    
                    console.log('Submission successful:', response);
                    
                    alert('Thank you for booking your test! We will contact you shortly.');
                    
                    form.reset();
                    form.classList.remove('was-validated');
                    
                    form.querySelectorAll('input[type="text"]').forEach(input => {
                        input.value = '';
                    });
                    
                    form.querySelectorAll('.form-control').forEach(input => {
                        input.classList.remove('is-valid', 'is-invalid');
                    });
                    
                    window.location.reload();
                    
                } catch (error) {
                    console.error('Submission failed:', error);
                    alert(error && error.message ? error.message : 'External integration disabled on staging.');
                } finally {
                    const submitButton = form.querySelector('.book-btn');
                    submitButton.textContent = 'BOOK YOUR TEST';
                    submitButton.disabled = false;
                }
            }
            
            form.classList.add('was-validated');
        }, false);
    });
})();