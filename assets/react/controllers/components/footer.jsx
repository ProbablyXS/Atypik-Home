import React from 'react';
import InstagramIcon from '@mui/icons-material/Instagram';
import FacebookIcon from '@mui/icons-material/Facebook';
import TwitterIcon from '@mui/icons-material/Twitter';

export default function () {
    return <>
        <div className="social-btn">
            <a href='/instagram' aria-label="Instagram"><InstagramIcon sx={{ color: 'white' }} /></a>
            <a href='/facebook' aria-label="Facebook"><FacebookIcon sx={{ color: 'white' }} /></a>
            <a href='/x' aria-label="X"><TwitterIcon sx={{ color: 'white' }} /></a>
        </div>
    </>
}