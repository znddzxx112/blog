
pragma solidity ^0.6.0;

pragma experimental ABIEncoderV2;


library safeMath {
    function safeMul(uint a, uint b) internal pure returns (uint) {
        uint c = a * b;
        assert(a == 0 || c / a == b);
        return c;
    }

    function safeDiv(uint a, uint b) internal pure returns (uint) {
        assert(b > 0);
        uint c = a / b;
        assert(a == b * c + a % b);
        return c;
    }

    function safeSub(uint a, uint b) internal pure returns (uint) {
        assert(b <= a);
        return a - b;
    }

    function safeAdd(uint a, uint b) internal pure returns (uint) {
        uint c = a + b;
        assert(c>=a && c>=b);
        return c;
    }
}


contract Base {

    address payable public owner;

    uint256 public total;

    uint256 public award;

    constructor() internal {
        owner = msg.sender;
        total = 0;
    }

    modifier onlyOwner {
        require(msg.sender == owner);
        _;
    }

    function say(string memory words) onlyOwner public view returns (string memory)  {
        return words;
    }

    function addTotal(uint256 value) onlyOwner external returns (uint256) {
        require(value > 0);
        total = safeMath.safeAdd(total, value);
        return total;
    }

    function awardTo(address payable addr) onlyOwner public payable returns (bool) {
        require(msg.value > uint(0), "value too low");
        addr.transfer(msg.value);
        award = safeMath.safeAdd(award, msg.value);
        return true;
    }
}

contract Second is Base {
    function printOwner() onlyOwner public view returns (address)  {
        return _getOwner();
    }

    function _getOwner() internal view returns (address)  {
        return owner;
    }

    //????????
    function decode(bytes memory signedString, bytes memory sha3Msg) public pure returns (address){
        // bytes memory signedString =hex"f4128988cbe7df8315440adde412a8955f7f5ff9a5468a791433727f82717a6753bd71882079522207060b681fbd3f5623ee7ed66e33fc8e581f442acbcf6ab800";

        bytes32  r = bytesToBytes32(slice(signedString, 0, 32));
        bytes32  s = bytesToBytes32(slice(signedString, 32, 32));
        byte  v = slice(signedString, 64, 1)[0];
        return ecrecoverDecode(sha3Msg, r, s, v);
    }

    //???????????????
    function slice(bytes memory data, uint start, uint len) private pure returns (bytes memory){
        bytes memory b = new bytes(len);

        for(uint i = 0; i < len; i++){
            b[i] = data[i + start];
        }

        return b;
    }

    //??ecrecover????
    function ecrecoverDecode(bytes memory sha3Msg, bytes32 r, bytes32 s, byte v1) private pure returns (address addr){
        uint8 v = uint8(v1) + 27;
        //  addr = ecrecover(hex"4e03657aea45a94fc7d47ba826c8d667c0d1e6e33a64a036ec44f58fa12d6c45", v, r, s);
        addr = ecrecover(bytesToBytes32(sha3Msg), v, r, s);
    }

    //bytes???bytes32
    function bytesToBytes32(bytes memory source) private pure returns (bytes32 result) {
        assembly {
            result := mload(add(source, 32))
        }
    }
}
