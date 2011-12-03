function more_info (rentalid ,address, cost, distance, available, utils_included, lease_required, furnished, empty_rooms)
{
    var class_id = "."+rentalid;
    var all_info = "Available: "+available
                    +"<br/>Utilities included: "+utils_included+"<br/>Lease required: "+lease_required
                    +"<br/>Furnished: "+furnished+"<br/>Rooms: "+empty_rooms;
    $(class_id).qtip({
        content: all_info,
        show: 'mouseover',
        hide: 'mouseout',   
    })
}
