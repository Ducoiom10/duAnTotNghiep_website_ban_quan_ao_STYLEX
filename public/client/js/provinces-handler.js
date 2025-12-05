// Address cascading selects handler
(function() {
    'use strict';
    
    // Get elements
    var $province = document.getElementById('province');
    var $district = document.getElementById('district');
    var $ward = document.getElementById('ward');
    var $cityHidden = document.querySelector('input[name="city"]');
    var $addressInput = document.querySelector('input[name="address"]');
    var provincesData = null;
    
    // Get JSON URL from data attribute or use default
    var jsonUrl = document.getElementById('province')?.dataset.jsonUrl || '/client/js/provinces-data.json';
    
    function updateStatus(elementId, message, isError){
        var el = document.getElementById(elementId);
        if (el) {
            el.textContent = message;
            el.style.color = isError ? '#d33' : '#666';
        }
    }

    function setDisabled(sel, disabled){ 
        sel.disabled = !!disabled; 
        if (disabled) sel.innerHTML = '<option value="">---</option>'; 
    }
    
    function setOptions(sel, list, placeholder){
        sel.innerHTML = '<option value="">'+ (placeholder||'Chọn') +'</option>';
        if (Array.isArray(list) && list.length > 0) {
            list.forEach(function(it){
                var opt = document.createElement('option'); 
                var code = it.code || it.id || '';
                var name = it.name || it.full_name || '';
                
                opt.value = String(code || ''); 
                opt.textContent = name || code || '';
                opt.dataset.name = name || ''; 
                opt.dataset.code = String(code || ''); 
                
                sel.appendChild(opt);
            });
            sel.disabled = false;
        } else {
            sel.innerHTML = '<option value="">' + (placeholder||'Chọn') + ' (Không có dữ liệu)</option>';
            sel.disabled = true;
        }
    }

    function syncCityHidden(){
        if (!$province || !$cityHidden) return;
        var pName = $province.options[$province.selectedIndex] ? ($province.options[$province.selectedIndex].dataset.name || '') : '';
        $cityHidden.value = pName;
    }

    function prependToAddress(){
        if (!$addressInput) return;
        var p = $province.options[$province.selectedIndex]?.dataset.name || '';
        var d = $district.options[$district.selectedIndex]?.dataset.name || '';
        var w = $ward.options[$ward.selectedIndex]?.dataset.name || '';
        var base = $addressInput.value || '';
        var parts = [base];
        if (w) parts.push(w); if (d) parts.push(d); if (p) parts.push(p);
        $addressInput.value = parts.filter(Boolean).join(', ');
    }

    // Load data from local JSON file
    function loadProvincesData() {
        if (!$province) return;
        
        updateStatus('province-status', 'Đang tải dữ liệu...', false);
        
        fetch(jsonUrl)
            .then(function(response) {
                if (!response.ok) {
                    throw new Error('Failed to load data: ' + response.status);
                }
                return response.json();
            })
            .then(function(data) {
                console.log('Data loaded successfully');
                
                // Transform data to match our structure
                if (Array.isArray(data)) {
                    // Data is array with structure: [{Id, Name, Districts: [{Id, Name, Wards: [{Id, Name}]}]}]
                    provincesData = data.map(function(p) {
                        return {
                            code: p.Id || p.id || p.code || '',
                            name: p.Name || p.name || p.full_name || '',
                            districts: (p.Districts || p.districts || []).map(function(d) {
                                return {
                                    code: d.Id || d.id || d.code || '',
                                    name: d.Name || d.name || d.full_name || '',
                                    wards: (d.Wards || d.wards || []).map(function(w) {
                                        return {
                                            code: w.Id || w.id || w.code || '',
                                            name: w.Name || w.name || w.full_name || ''
                                        };
                                    })
                                };
                            })
                        };
                    });
                } else if (data.data && Array.isArray(data.data)) {
                    provincesData = data.data;
                } else if (data.provinces && Array.isArray(data.provinces)) {
                    provincesData = data.provinces;
                } else {
                    // Try to find array in object
                    for (var key in data) {
                        if (Array.isArray(data[key]) && data[key].length > 0) {
                            var sample = data[key][0];
                            if (sample && (sample.code || sample.name || sample.districts || sample.Id || sample.Name || sample.Districts)) {
                                provincesData = data[key];
                                console.log('Found provinces data in key:', key);
                                break;
                            }
                        }
                    }
                }
                
                if (provincesData && Array.isArray(provincesData) && provincesData.length > 0) {
                    console.log('Provinces data loaded:', provincesData.length, 'provinces');
                    loadProvinces();
                } else {
                    throw new Error('Invalid data format');
                }
            })
            .catch(function(error) {
                console.error('Error loading provinces data:', error);
                updateStatus('province-status', '❌ Không thể tải dữ liệu', true);
                if ($province) {
                    $province.innerHTML = '<option value="">⚠️ Không thể tải dữ liệu</option>';
                }
                setDisabled($district, true);
                setDisabled($ward, true);
            });
    }
    
    // Load provinces from loaded data
    function loadProvinces() {
        if (!$province) return;
        
        if (provincesData && Array.isArray(provincesData) && provincesData.length > 0) {
            var provinces = provincesData.map(function(p) {
                return { 
                    code: p.code || p.id || '', 
                    name: p.name || p.full_name || '' 
                };
            });
            setOptions($province, provinces, 'Chọn tỉnh/thành');
            updateStatus('province-status', '✓ Đã tải ' + provinces.length + ' tỉnh/thành phố', false);
        } else {
            updateStatus('province-status', '⚠️ Không có dữ liệu', true);
            $province.innerHTML = '<option value="">⚠️ Không có dữ liệu</option>';
            setDisabled($district, true);
            setDisabled($ward, true);
        }
    }

    // Initialize on DOM ready
    function init() {
        if (!$province || !$district || !$ward) {
            console.warn('Province, district, or ward elements not found');
            return;
        }
        
        // Load data on page load
        loadProvincesData();

        $province.addEventListener('change', function(){
            var code = this.value;
            if (!code) {
                setDisabled($district, true);
                setDisabled($ward, true);
                return;
            }
            
            var name = this.options[this.selectedIndex]?.dataset.name || '';
            syncCityHidden();
            
            // Reset district and ward
            setDisabled($district, true);
            setDisabled($ward, true);
            updateStatus('district-status', '', false);
            
            // Get districts from static data
            if (provincesData && Array.isArray(provincesData)) {
                var selectedProvince = provincesData.find(function(p){ 
                    return String(p.code) === String(code) || p.name === name || p.name === code;
                });
                
                if (selectedProvince && selectedProvince.districts && Array.isArray(selectedProvince.districts) && selectedProvince.districts.length > 0) {
                    setOptions($district, selectedProvince.districts, 'Chọn quận/huyện');
                    updateStatus('district-status', '✓ Đã tải ' + selectedProvince.districts.length + ' quận/huyện', false);
                } else {
                    updateStatus('district-status', '⚠️ Không có dữ liệu quận/huyện', true);
                    setDisabled($district, true);
                }
            } else {
                updateStatus('district-status', '⚠️ Không có dữ liệu', true);
                setDisabled($district, true);
            }
        });

        $district.addEventListener('change', function(){
            var code = this.value;
            if (!code) {
                setDisabled($ward, true);
                return;
            }
            
            // Reset ward
            setDisabled($ward, true);
            updateStatus('ward-status', '', false);
            
            // Get wards from static data
            var provinceCode = $province.value;
            if (provincesData && Array.isArray(provincesData) && provinceCode) {
                var selectedProvince = provincesData.find(function(p){ 
                    return String(p.code) === String(provinceCode);
                });
                
                if (selectedProvince && selectedProvince.districts) {
                    var selectedDistrict = selectedProvince.districts.find(function(d){ 
                        return String(d.code) === String(code);
                    });
                    
                    if (selectedDistrict && selectedDistrict.wards && Array.isArray(selectedDistrict.wards) && selectedDistrict.wards.length > 0) {
                        setOptions($ward, selectedDistrict.wards, 'Chọn phường/xã');
                        updateStatus('ward-status', '✓ Đã tải ' + selectedDistrict.wards.length + ' phường/xã', false);
                    } else {
                        updateStatus('ward-status', '⚠️ Không có dữ liệu phường/xã', true);
                        setDisabled($ward, true);
                    }
                } else {
                    updateStatus('ward-status', '⚠️ Không có dữ liệu', true);
                    setDisabled($ward, true);
                }
            } else {
                updateStatus('ward-status', '⚠️ Không có dữ liệu', true);
                setDisabled($ward, true);
            }
        });

        $ward.addEventListener('change', function(){ 
            prependToAddress(); 
        });
    }
    
    // Run when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();

