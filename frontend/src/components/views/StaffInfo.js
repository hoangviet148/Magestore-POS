const StaffInfo = () => {
  return (
    <div className="col-3">Staff: {localStorage.getItem("staffName")}</div>
  );
};

export default StaffInfo;
